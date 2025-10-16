<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
use App\Http\Controllers\AuthController;
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgotPassword');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgotPassword.post');

Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('reset-password');
Route::post('/reset-password', [AuthController::class, 'verifyOtpAndChangePassword'])->name('reset-password.post');
Route::get('/dashboard', [AuthController::class, 'dashboard']);
