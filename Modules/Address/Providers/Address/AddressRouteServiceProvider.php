<?php

namespace Modules\Address\Providers\Address;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Modules\Address\Controllers\V1\AddressController;

class AddressRouteServiceProvider extends RouteServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            Route::middleware('api')
                ->controller(AddressController::class)
                ->prefix('api/v1/address')
                ->name('address.')
                ->group(__DIR__ . '/../../Routes/V1/address.php');
        });
    }
}
