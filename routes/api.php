<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Unauthenticated admin routes
Route::post('auth/login', [AuthController::class, 'login']);

// Authenticated admin routes
Route::middleware(['auth:api'])->group(function () {
    Route::get('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/refresh', [AuthController::class, 'refresh']);
    Route::get('auth/profile', [AuthController::class, 'profile']);
    Route::put('auth/password', [AuthController::class, 'updatePassword']);
});

// Candidates routes
// Route::get('user', [UserController::class, 'getAll']);
// Route::get('user/{id}', [UserController::class, 'getById']);
// Route::post('user', [UserController::class, 'create']);
// Route::put('user', [UserController::class, 'update']);
// Route::delete('user/{id}', [UserController::class, 'delete']);