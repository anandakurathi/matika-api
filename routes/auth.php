<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\CodeCheckController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('auth:sanctum')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['throttle:3,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth:sanctum', 'throttle:1,1'])
    ->name('verification.send');

Route::post('/logout', LogoutController::class)
    ->middleware('auth:sanctum')
    ->name('logout');

Route::post('/forgot-password', ForgotPasswordController::class)
    ->middleware(['guest'])
    ->name('password.email');

Route::post('/new-password', CodeCheckController::class)
    ->middleware('guest')
    ->name('password.reset');
