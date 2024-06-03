<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\UserProfileController;

Route::middleware('auth:sanctum')->group(function () {
    // TodoControllerのルート
    Route::apiResource('todos', TodoController::class);

    // UserProfileControllerのルート
    Route::put('/user/{user}/update', [UserProfileController::class, 'update']);
    Route::get('/profile', [UserProfileController::class, 'profile']);
});

// AuthenticationControllerのルート
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
