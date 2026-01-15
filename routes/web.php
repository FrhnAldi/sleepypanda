<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\JurnalTidurController;
use App\Http\Controllers\DatabaseUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route untuk welcome page (halaman pertama)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route untuk halaman publik (guest)
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    
    // Forgot Password Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
});

// Route untuk user yang sudah login (auth)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');
    
    // Jurnal Routes
    Route::get('/jurnal', [JurnalTidurController::class, 'daily'])->name('jurnal');
    Route::get('/jurnal/weekly', [JurnalTidurController::class, 'weekly'])->name('jurnal.tidur.weekly');
    Route::get('/jurnal/monthly', [JurnalTidurController::class, 'monthly'])->name('jurnal.tidur.monthly');
    Route::get('/report', function () {
    return view('pages.report');
    })->name('report');
    
    // AJAX Routes untuk filtering data
    Route::post('/jurnal/filter', [JurnalTidurController::class, 'getFilteredData'])->name('jurnal.tidur.filter');
    Route::post('/jurnal/chart-data', [JurnalTidurController::class, 'getChartData'])->name('jurnal.tidur.chart');
    
    Route::get('/database-user', [App\Http\Controllers\DatabaseUserController::class, 'index'])->name('database.user');
    Route::get('/database-user/{id}', [App\Http\Controllers\DatabaseUserController::class, 'show']);
    Route::put('/database-user/{id}', [App\Http\Controllers\DatabaseUserController::class, 'update']);
    Route::post('/database-user/{id}/reset-password', [App\Http\Controllers\DatabaseUserController::class, 'resetPassword']);
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Routes untuk Forgot Password dengan OTP
Route::post('/api/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('api.forgot-password');
Route::post('/api/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('api.verify-otp');
Route::post('/api/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('api.reset-password');

