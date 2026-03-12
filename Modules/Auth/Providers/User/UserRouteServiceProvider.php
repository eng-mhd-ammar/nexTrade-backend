<?php

namespace Modules\Auth\Providers\User;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Modules\Auth\Controllers\V1\UserController;

class UserRouteServiceProvider extends RouteServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            Route::middleware('api')
                ->controller(UserController::class)
                ->prefix('api/v1/user')
                ->name('user.')
                ->group(__DIR__ . '/../../Routes/V1/user.php');
        });
    }
}
