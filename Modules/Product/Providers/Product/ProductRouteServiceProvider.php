<?php

namespace Modules\Product\Providers\Product;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Modules\Product\Controllers\V1\ProductController;

class ProductRouteServiceProvider extends RouteServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            Route::middleware('api')
                ->controller(ProductController::class)
                ->prefix('api/v1/product')
                ->name('product.')
                ->group(__DIR__ . '/../../Routes/V1/product.php');
        });
    }
}
