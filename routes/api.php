<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// =====================================
// PUBLIC ROUTES
// =====================================

// POIN C: Register endpoint
Route::post('/register', [ApiAuthController::class, 'register']);

// POIN D: Login endpoint - Update untuk menggunakan hashed_password SHA-256
Route::post('/login', [ApiAuthController::class, 'login']);

// Forgot Password routes
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('api.forgot-password');
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('api.verify-otp');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('api.reset-password');

// =====================================
// PROTECTED ROUTES (Require JWT Token)
// =====================================

Route::middleware('auth:api')->group(function () {
    // Get authenticated user
    Route::get('/user', [ApiAuthController::class, 'user']);
    
    // Logout
    Route::post('/logout', [ApiAuthController::class, 'logout']);
});