<?php

namespace Modules\Auth\Providers\UserType;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Modules\Auth\Controllers\V1\UserTypeController;

class UserTypeRouteServiceProvider extends RouteServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            Route::middleware('api')
                ->controller(UserTypeController::class)
                ->prefix('api/v1/user-type')
                ->name('user-type.')
                ->group(__DIR__ . '/../../Routes/V1/user-type.php');
        });
    }
}
