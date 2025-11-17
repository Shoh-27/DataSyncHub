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


}
