<?php

use App\Http\Controllers\Api\users\FavoritesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::get('/test', function () {
//     throw new Exception('Test Exception');
// })->middleware();

// Route::middleware(['auth:sanctum'])->post('/v1/favorite/create', [FavoritesController::class, 'addOrRemove']);
// Route::middleware(['auth:sanctum'])->post('/v1/favorite/create', function () {
//     dd('test', auth()->user());
// });

// Route::group(['middleware' => ['auth:sanctum', 'ability:user']], function () {
//     Route::post('/', function () {
//         return 'User';
//     });
// });
// Route::group(['middleware' => ['auth:sanctum', 'ability:admin']], function () {
//     Route::post('/admin', function () {
//         return 'Admin';
//     });
// });


// Route::middleware('auth:sanctum')->post('/', function (Request $request) {
//     return $request->user();
// });
// Route::post('/pagination', [TestController::class, 'pagination']);
