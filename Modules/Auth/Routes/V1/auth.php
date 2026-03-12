<?php

namespace Modules\Auth\Routes\V1;

use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::post('/signup', 'signup');
    Route::post('/signup-with-store', 'signupWithStore');
    Route::post('/login', 'login');
    Route::post('/send-otp', 'send_otp');
    Route::post('/check-otp', 'check_otp');
    Route::post('/forgot-password', 'sendResetLink');
});

Route::get('/reset-password/{token}', function ($token) {
    return view('auth::Auth.reset-password', ['token' => $token]);
})->name('password.reset')->middleware(['web']);

Route::post('/reset-password', 'resetPassword')->name('password.update')->middleware(['web']);
