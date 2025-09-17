<?php

use App\Http\Controllers\Api\Users\ItemsController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', 'ability:user']], function () {
    Route::post('/getItems', [ItemsController::class, 'getItems']);
    Route::post('/search', [ItemsController::class, 'search']);
});