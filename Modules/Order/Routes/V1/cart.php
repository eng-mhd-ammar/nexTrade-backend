<?php

namespace Modules\Auth\Routes\V1;

use Illuminate\Support\Facades\Route;
use Modules\Address\Middlewares\AddressOwner;

Route::middleware(['auth:sanctum', 'ability:user,admin'])->group(function () {
    Route::post('/create', 'create');
    Route::get('/', 'index');

    Route::middleware([AddressOwner::class])->group(function () {
        Route::post('/update/{modelId}', 'update');
        Route::delete('/delete/{modelId}', 'delete');
        Route::get('/show/{modelId}', 'show');
        Route::delete('/force-delete/{modelId}', 'forceDelete');
        Route::get('/restore/{modelId}', 'restore');
    });
});
