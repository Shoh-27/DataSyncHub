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

}
