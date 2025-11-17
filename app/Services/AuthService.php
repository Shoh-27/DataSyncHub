<?php

namespace App\Services;

use App\Models\User;
use App\Models\EmailVerificationToken;
use App\Notifications\EmailVerificationNotification;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class AuthService
{
    public function __construct(
        private WalletService $walletService,
        private GamificationService $gamificationService
    ) {}

    /**
     * Register a new user
     */
    public function register(array $data): User
    {
        return DB::connection('mysql')->transaction(function () use ($data) {
            // Create user
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'timezone' => $data['timezone'] ?? 'UTC',
                'language' => $data['language'] ?? 'en',
                'account_status' => 'active',
            ]);

            // Create wallet with initial connects
            $this->walletService->createWallet($user);

            // Initialize gamification profile
            $this->gamificationService->initializeUserProfile($user->id);

            // Send email verification
            $this->sendEmailVerification($user);

            event(new Registered($user));

            return $user;
        });
    }

    /**
     * Authenticate user and generate token
     */
    public function login(array $credentials, bool $remember = false): array
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new \Exception('Invalid credentials', 401);
        }

        if ($user->account_status !== 'active') {
            throw new \Exception('Your account has been ' . $user->account_status, 403);
        }

        // Check if 2FA is enabled
        if ($user->two_factor_enabled) {
            return [
                'requires_2fa' => true,
                'user_id' => $user->id,
            ];
        }

        return $this->generateAuthResponse($user, $remember);
    }

    /**
     * Generate authentication response with tokens
     */
    public function generateAuthResponse(User $user, bool $remember = false): array
    {
        // Revoke existing tokens
        $user->tokens()->delete();

        // Generate new token
        $expiresAt = $remember ? now()->addDays(30) : now()->addDays(7);

        $token = $user->createToken(
            'auth-token',
            ['*'],
            $expiresAt
        )->plainTextToken;

        return [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => $expiresAt->toISOString(),
        ];
    }

    /**
     * Send email verification
     */
    public function sendEmailVerification(User $user): void
    {
        // Delete old tokens
        EmailVerificationToken::where('user_id', $user->id)->delete();

        // Create new token
        $token = EmailVerificationToken::create([
            'user_id' => $user->id,
            'token' => EmailVerificationToken::generateToken(),
            'expires_at' => now()->addHours(24),
        ]);

        // Send notification
        $user->notify(new EmailVerificationNotification($token->token));
    }

    /**
     * Verify email with token
     */
    public function verifyEmail(string $token): User
    {
        $verificationToken = EmailVerificationToken::where('token', $token)
            ->valid()
            ->firstOrFail();

        $user = $verificationToken->user;

        if ($user->hasVerifiedEmail()) {
            throw new \Exception('Email already verified');
        }

        $user->markEmailAsVerified();
        $verificationToken->delete();

        // Award XP for email verification (profile completion)
        $this->gamificationService->awardXp($user->id, 50, 'email_verified');

        return $user;
    }

    /**
     * Send password reset link
     */
    public function sendPasswordResetLink(string $email): void
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            // Don't reveal if email exists
            return;
        }

        $token = Str::random(64);

        DB::connection('mysql')->table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        $user->notify(new PasswordResetNotification($token));
    }




}
