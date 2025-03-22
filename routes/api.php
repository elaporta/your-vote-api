<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Unauthenticated routes
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/signup', [AuthController::class, 'signup'] );

// Authenticated routes
Route::middleware(['auth:api'])->group(function () {
    Route::get('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/refresh', [AuthController::class, 'refresh']);
    Route::get('auth/profile', [AuthController::class, 'profile']);
});

// Admin routes
Route::middleware(['auth:api', 'role:admin'])->group(function (){
    Route::get('user', [UserController::class, 'getAll']);
    Route::get('user/{id}', [UserController::class, 'getById']);
    Route::post('user', [UserController::class, 'create']);
    Route::put('user', [UserController::class, 'update']);
    Route::delete('user/{id}', [UserController::class, 'delete']);
});