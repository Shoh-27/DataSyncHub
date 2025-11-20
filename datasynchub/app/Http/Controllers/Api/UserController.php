<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    /**
     * Update user profile
     */
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->updateProfile(
                $request->user(),
                $request->validated()
            );

            return response()->json([
                'message' => 'Profile updated successfully',
                'user' => new UserResource($user),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Profile update failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get user profile by ID
     */
    public function show(int $id): JsonResponse
    {
        try {
            $profile = $this->userService->getUserProfile($id);

            return response()->json([
                'user' => new UserResource($profile['user']),
                'gamification' => $profile['gamification'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch user profile',
                'error' => $e->getMessage(),
            ], $e->getCode() ?: 404);
        }
    }

    /**
     * Deactivate account
     */
    public function deactivate(Request $request): JsonResponse
    {
        try {
            $this->userService->deactivateAccount($request->user());

            return response()->json([
                'message' => 'Account deactivated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Account deactivation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete account (GDPR)
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->validate([
            'confirmation' => 'required|string|in:DELETE MY ACCOUNT',
        ]);

        try {
            $this->userService->deleteAccount($request->user());

            return response()->json([
                'message' => 'Account scheduled for deletion in 90 days',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Account deletion failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
