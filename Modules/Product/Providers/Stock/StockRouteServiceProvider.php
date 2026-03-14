<?php

namespace Modules\Product\Providers\Stock;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Modules\Product\Controllers\V1\StockController;

class StockRouteServiceProvider extends RouteServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            Route::middleware('api')
                ->controller(StockController::class)
                ->prefix('api/v1/stock')
                ->name('stock.')
                ->group(__DIR__ . '/../../Routes/V1/stock.php');
        });
    }
}
