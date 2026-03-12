<?php

namespace Modules\Auth\Providers\Auth;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Modules\Auth\Controllers\V1\AuthController;

class AuthRouteServiceProvider extends RouteServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            Route::middleware('api')
                ->controller(AuthController::class)
                ->prefix('api/v1/auth')
                ->name('auth.')
                ->group(__DIR__ . '/../../Routes/V1/auth.php');
        });
    }
}
