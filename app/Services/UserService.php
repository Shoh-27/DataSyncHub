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


}
