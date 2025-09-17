<?php

use App\Http\Controllers\Api\Users\CartController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', 'ability:user']], function () {
    Route::post('/add', [CartController::class, 'add']);
    Route::post('/delete', [CartController::class, 'delete']);
    Route::post('/get', [CartController::class, 'get']);
    Route::post('/update', [CartController::class, 'update']);
    Route::post('/remove', [CartController::class, 'remove']);
});
