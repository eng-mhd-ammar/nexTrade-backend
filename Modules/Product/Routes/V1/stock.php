<?php

namespace Modules\Auth\Routes\V1;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'ability:user,admin,delivery'])->group(function () {
    Route::get('/show/{modelId}', 'show');
    Route::get('/', 'index');

    Route::middleware(['ability:admin'])->group(function () {
        Route::post('/create', 'create');
        Route::post('/update/{modelId}', 'update');
        Route::delete('/delete/{modelId}', 'delete');
        Route::delete('/force-delete/{modelId}', 'forceDelete');
        Route::get('/restore/{modelId}', 'restore');
    });
});
