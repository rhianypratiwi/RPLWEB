<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MataKuliahController;

// ==========================
// 🔐 AUTH ROUTES
// ==========================
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgotPassword');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgotPassword.post');

Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('reset-password');
Route::post('/reset-password', [AuthController::class, 'verifyOtpAndChangePassword'])->name('reset-password.post');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================
// 🏠 DASHBOARD & FITUR
// ==========================
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('/kelas', [MataKuliahController::class, 'index'])->name('kelas');
Route::get('/profil', [AuthController::class, 'profil'])->name('profil');
