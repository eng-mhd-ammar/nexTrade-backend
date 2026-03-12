<?php

namespace Modules\Auth\Routes\V1;

use Illuminate\Support\Facades\Route;

Route::middleware([/*'auth:sanctum', 'is_admin'*/])->group(function () {
    Route::post('/create', 'create');
    Route::post('/update/{role_id}', 'update');
    Route::delete('/delete/{role_id}', 'delete');
    Route::get('/show/{role_id}', 'show');
    Route::get('/', 'index');
    Route::delete('/force-delete/{role_id}', 'forceDelete');
    Route::get('/restore/{role_id}', 'restore');
});
