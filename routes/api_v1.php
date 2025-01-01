<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\BlogController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Public routes for guest users (cannot be accessed if the user is authenticated)
    Route::middleware('guest')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
    });
    Route::post('refresh', [AuthController::class, 'refreshToken']);
    // Protected routes (require JWT token) //'jwt.verify',
    Route::middleware('jwt.verify')->group(function () {
        // Profile route
        Route::get('profile', [ProfileController::class, 'getProfile']);
        // Category CRUD routes (Admin only)
        Route::middleware('admin.role')->group(function () {
            Route::get('categories', [CategoryController::class, 'index']);
            Route::post('categories', [CategoryController::class, 'store']);
            Route::get('categories/{id}', [CategoryController::class, 'show']);
            Route::put('categories/{id}', [CategoryController::class, 'update']);
            Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
        });
        #Blog CRUD Routs [All Authenticated Users]
        Route::apiResource('blogs', BlogController::class);

    });
});
