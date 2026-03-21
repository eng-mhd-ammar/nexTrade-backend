<?php

namespace Modules\Auth\Routes\V1;

use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:user'])->group(function () {
//     Route::post('/create', 'create'/*function () {
//         dd(auth()->user());
//     }*/);
//     Route::get('/', 'index');

//     Route::middleware([/*AddressOwner::class*/])->group(function () {
//         Route::post('/update/{modelId}', 'update');
//         Route::delete('/delete/{modelId}', 'delete');
//         Route::get('/show/{modelId}', 'show');
//         Route::delete('/force-delete/{modelId}', 'forceDelete');
//         Route::get('/restore/{modelId}', 'restore');
//     });
// });
Route::middleware(['auth:user'])->group(function () {
    Route::get('/', 'index');
    Route::get('/show/{address_id}', 'show');
    Route::post('/create', 'create');
    Route::delete('/delete/{address_id}', 'delete');

    Route::middleware([])->group(function () {
        Route::post('/update/{address_id}', 'update');
        Route::delete('/force-delete/{address_id}', 'forceDelete');
        Route::get('/restore/{address_id}', 'restore');
    });
});
