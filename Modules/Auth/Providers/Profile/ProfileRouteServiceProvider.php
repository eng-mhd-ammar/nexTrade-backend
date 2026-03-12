<?php

namespace Modules\Auth\Providers\Profile;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Modules\Auth\Controllers\V1\ProfileController;

class ProfileRouteServiceProvider extends RouteServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            Route::middleware('api')
                ->controller(ProfileController::class)
                ->prefix('api/v1/profile')
                ->name('profile.')
                ->group(__DIR__ . '/../../Routes/V1/profile.php');
        });
    }
}
