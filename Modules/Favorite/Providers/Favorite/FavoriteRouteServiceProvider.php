<?php

namespace Modules\Favorite\Providers\Favorite;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Modules\Favorite\Controllers\V1\FavoriteController;

class FavoriteRouteServiceProvider extends RouteServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            Route::middleware('api')
                ->controller(FavoriteController::class)
                ->prefix('api/v1/favorite')
                ->name('favorite.')
                ->group(__DIR__ . '/../../Routes/V1/favorite.php');
        });
    }
}
