<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VoterController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\VoteController;

// Unauthenticated admin routes
Route::post('auth/login', [AuthController::class, 'login']);

// Authenticated admin routes
Route::middleware(['auth:api'])->group(function () {
    Route::get('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/refresh', [AuthController::class, 'refresh']);
    Route::get('auth/profile', [AuthController::class, 'profile']);
    Route::put('auth/password', [AuthController::class, 'updatePassword']);

    Route::get('voter', [VoterController::class, 'getAll']);
    Route::get('voter/{id}', [VoterController::class, 'getById']);
    Route::post('voter', [VoterController::class, 'create']);
    Route::put('voter', [VoterController::class, 'update']);
    Route::delete('voter/{id}', [VoterController::class, 'delete']);

    Route::get('candidate/{id}', [CandidateController::class, 'getById']);
    Route::post('candidate', [CandidateController::class, 'create']);
    Route::put('candidate', [CandidateController::class, 'update']);
    Route::delete('candidate/{id}', [CandidateController::class, 'delete']);
});

// Public routes
Route::get('candidate', [CandidateController::class, 'getAll']);
Route::get('candidate/by/votes', [CandidateController::class, 'getByVotes']);
Route::get('vote', [VoteController::class, 'getAll']);
Route::get('vote/{id}', [VoteController::class, 'getById']);
Route::post('vote', [VoteController::class, 'create']);
