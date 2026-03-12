<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\SignUpController;
use Illuminate\Support\Facades\Route;

// Route::group([], function () {
//     Route::group([], function () {
//         // Sign-up routes
//         Route::post('/signUp', [SignUpController::class, 'signUp']);
//         Route::post('/verifyCodeSignUp', [SignUpController::class, 'verifyCodeSignUp']);
//         Route::post('/resendVerificationCode', [SignUpController::class, 'resendVerificationCode']);

//         // Login and Logout routes
//         Route::post('/login', [LoginController::class, 'login']);
//         Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
//         Route::post('/checkEmail', [LoginController::class, 'checkEmail']);
//         Route::post('/resetPassword', [LoginController::class, 'resetPassword']);
//         Route::post('/verifyCodeForgetPassword', [LoginController::class, 'verifyCodeForgetPassword']);
//     });
// });
