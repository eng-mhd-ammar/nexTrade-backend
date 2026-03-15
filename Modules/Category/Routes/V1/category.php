<?php

namespace Modules\Auth\Routes\V1;

use Illuminate\Support\Facades\Route;
use Modules\Address\Middlewares\AddressOwner;

Route::middleware([])->group(function () {
    Route::get('/', 'index');
    Route::get('/show/{modelId}', 'show');

    Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {
        Route::post('/create', 'create');
        Route::post('/update/{modelId}', 'update');
        Route::delete('/delete/{modelId}', 'delete');
        Route::delete('/force-delete/{modelId}', 'forceDelete');
        Route::get('/restore/{modelId}', 'restore');
    });
});
