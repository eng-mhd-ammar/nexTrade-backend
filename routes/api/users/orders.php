<?php

use App\Http\Controllers\Api\Users\OrdersController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', 'ability:user']], function () {
    Route::post('/add', [OrdersController::class, 'add']);
    Route::post('/getPending', [OrdersController::class, 'getPending']);
    Route::post('/getArchived', [OrdersController::class, 'getArchived']);
    Route::post('/getDetails', [OrdersController::class, 'getDetails']);
    Route::post('/delete', [OrdersController::class, 'delete']);
    Route::post('/rate', [OrdersController::class, 'rate']);
});
