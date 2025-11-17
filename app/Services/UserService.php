<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class UserService
{
    public function __construct(
        private GamificationService $gamificationService
    ) {}

    /**
     * Update user profile
     */
    public function updateProfile(User $user, array $data): User
    {
        $wasProfileIncomplete = $this->isProfileIncomplete($user);

        // Handle avatar upload
        if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
            $data['avatar_url'] = $this->uploadAvatar($user, $data['avatar']);
            unset($data['avatar']);
        }

        $user->update($data);

        // Award XP if profile completed
        if ($wasProfileIncomplete && !$this->isProfileIncomplete($user)) {
            $this->gamificationService->awardXp($user->id, 50, 'profile_completed');
        }

        return $user->fresh();
    }

    /**
     * Upload user avatar
     */
    private function uploadAvatar(User $user, UploadedFile $file): string
    {
        // Delete old avatar
        if ($user->avatar_url) {
            Storage::disk('public')->delete($user->avatar_url);
        }

        $filename = 'avatars/' . $user->id . '_' . time() . '.' . $file->extension();
        $path = $file->storeAs('public', $filename);

        return Storage::url($filename);
    }

    /**
     * Check if profile is incomplete
     */
    private function isProfileIncomplete(User $user): bool
    {
        return empty($user->bio) ||
            empty($user->avatar_url) ||
            empty($user->skills) ||
            count($user->skills) < 3;
    }

    /**
     * Get user profile with gamification data
     */
    public function getUserProfile(int $userId): array
    {
        $user = User::findOrFail($userId);

        if (!$user->isActive()) {
            throw new \Exception('User account is not active', 403);
        }

        $gamificationData = $this->gamificationService->getUserStats($userId);

        return [
            'user' => $user,
            'gamification' => $gamificationData,
        ];
    }

    /**
     * Deactivate user account
     */
    public function deactivateAccount(User $user): void
    {
        $user->update([
            'account_status' => 'deactivated',
        ]);

        // Revoke all tokens
        $user->tokens()->delete();
    }

    /**
     * Delete user account (GDPR)
     */
    public function deleteAccount(User $user): void
    {
        // Delete avatar
        if ($user->avatar_url) {
            Storage::disk('public')->delete($user->avatar_url);
        }

        // Soft delete user
        $user->delete();

        // Schedule permanent deletion after 90 days
        // This would be handled by a scheduled job
    }

    /**
     * Suspend user account (admin action)
     */
    public function suspendAccount(int $userId, string $reason): void
    {
        $user = User::findOrFail($userId);

        $user->update([
            'account_status' => 'suspended',
        ]);

        $user->tokens()->delete();

        // Log suspension reason (would be stored in admin logs)
    }

    /**
     * Reactivate suspended account
     */
    public function reactivateAccount(int $userId): void
    {
        $user = User::findOrFail($userId);

        $user->update([
            'account_status' => 'active',
        ]);
    }
}
