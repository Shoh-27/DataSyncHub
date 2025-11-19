<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes - Authentication & User Management
|--------------------------------------------------------------------------
*/

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/verify-email', [AuthController::class, 'verifyEmail']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    // Auth endpoints
    Route::prefix('auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
        Route::post('/resend-verification', [AuthController::class, 'resendVerification']);
    });

    // User profile endpoints
    Route::prefix('users')->group(function () {
        Route::put('/profile', [UserController::class, 'updateProfile']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/deactivate', [UserController::class, 'deactivate']);
        Route::delete('/account', [UserController::class, 'destroy']);
    });
});
