<?php

namespace Modules\Auth\Routes\V1;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/update', 'update');
    Route::delete('/delete', 'delete');
    Route::get('/show', 'show');
});
