<?php

namespace Modules\Auth\Routes\V1;

use Illuminate\Support\Facades\Route;

Route::middleware([/*'auth:sanctum', 'is_admin'*/])->group(function () {
    Route::post('/create', 'create');
    Route::post('/update/{user_id}', 'update');
    Route::delete('/delete/{user_id}', 'delete');
    Route::get('/show/{user_id}', 'show');
    Route::get('/', 'index');
    Route::post('/delete-many', 'deleteMany');
    Route::delete('/force-delete/{user_id}', 'forceDelete');
    Route::get('/restore/{user_id}', 'restore');
    Route::get('/switch-activation/{user_id}', 'switchActivation');
});
