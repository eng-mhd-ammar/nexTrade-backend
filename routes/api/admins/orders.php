<?php

use App\Http\Controllers\Api\Admins\OrdersController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', 'ability:admin']], function () {
    Route::post('/approve', [OrdersController::class, 'approve']);
    Route::post('/prepare', [OrdersController::class, 'prepare']);
    Route::post('/getArchived', [OrdersController::class, 'getArchived']);
    Route::post('/getPending', [OrdersController::class, 'getPending']);
    Route::post('/getAccepted', [OrdersController::class, 'getAccepted']);
    Route::post('/getDetails', [OrdersController::class, 'getDetails']);
});
