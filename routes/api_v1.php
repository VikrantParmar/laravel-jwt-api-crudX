<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\BlogController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('test', [AuthController::class, 'test']);
    // Public routes for guest users (cannot be accessed if the user is authenticated)
    Route::middleware('guest')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
    });
    //Route::post('refresh', [AuthController::class, 'refreshToken']);
    Route::post('refresh-token', [AuthController::class, 'refreshToken'])->middleware('jwt.refresh');
    Route::get('blogs', [BlogController::class, 'index']);

    // Protected routes (require JWT token) //'jwt.verify',
    Route::middleware('jwt.verify')->group(function () {
        // Profile route
        Route::get('profile', [ProfileController::class, 'getProfile']);
        Route::post('profile', [ProfileController::class, 'updateProfile']);
        Route::post('update-password', [ProfileController::class, 'updatePassword']);
        // Category CRUD routes (Admin only)
        Route::get('categories/all', [CategoryController::class, 'allCategory']);
        Route::middleware('admin.role')->group(function () {
            Route::get('categories', [CategoryController::class, 'index']);
            Route::post('categories', [CategoryController::class, 'store']);
            Route::get('categories/{id}', [CategoryController::class, 'show']);
            Route::put('categories/{id}', [CategoryController::class, 'update']);
            Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
        });

        #Blog CRUD Routs [All Authenticated Users]
      #  Route::apiResource('blogs', BlogController::class);
        Route::get('blogs/my', [BlogController::class, 'myBlog']);
        Route::get('blogs/{id}', [BlogController::class, 'show']); // Get a specific blog
        // Create a new blog
        Route::post('blogs', [BlogController::class, 'store']); // Create blog
        // Update an existing blog
        Route::put('blogs/{id}', [BlogController::class, 'update']); // Update blog
        // Delete a blog
        Route::delete('blogs/{id}', [BlogController::class, 'destroy']); // Delete blog
        // Blog route for authenticated users (e.g., their own blogs)


    });

});
