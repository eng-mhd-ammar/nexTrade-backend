<?php

namespace Modules\Order\Providers\Cart;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Modules\Order\Controllers\V1\CartController;

class CartRouteServiceProvider extends RouteServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            Route::middleware('api')
                ->controller(CartController::class)
                ->prefix('api/v1/cart')
                ->name('cart.')
                ->group(__DIR__ . '/../../Routes/V1/cart.php');
        });
    }
}
