<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            // Auth ==================================================
            Route::middleware('api')
                ->prefix('api/auth')
                ->group(base_path('routes/api/auth.php'));
            // Auth ==================================================
            // Admins ================================================
            Route::middleware('api')
                ->prefix('api/admins/categories')
                ->group(base_path('routes/api/admins/categories.php'));
            Route::middleware('api')
                ->prefix('api/admins/items')
                ->group(base_path('routes/api/admins/items.php'));
            Route::middleware('api')
                ->prefix('api/admins/orders')
                ->group(base_path('routes/api/admins/orders.php'));
            // Admins ================================================
            // Deliveries ============================================
            Route::middleware('api')
                ->prefix('api/deliveries/orders')
                ->group(base_path('routes/api/deliveries/orders.php'));
            // Deliveries ============================================
            // Users =================================================
            Route::middleware('api')
                ->prefix('api/users/categories')
                ->group(base_path('routes/api/users/categories.php'));
            Route::middleware('api')
                ->prefix('api/users/items')
                ->group(base_path('routes/api/users/items.php'));
            Route::middleware('api')
                ->prefix('api/users/favorites')
                ->group(base_path('routes/api/users/favorites.php'));
            Route::middleware('api')
                ->prefix('api/users/cart')
                ->group(base_path('routes/api/users/cart.php'));
            Route::middleware('api')
                ->prefix('api/users/addresses')
                ->group(base_path('routes/api/users/addresses.php'));
            Route::middleware('api')
                ->prefix('api/users/coupons')
                ->group(base_path('routes/api/users/coupons.php'));
            Route::middleware('api')
                ->prefix('api/users/orders')
                ->group(base_path('routes/api/users/orders.php'));
            Route::middleware('api')
                ->prefix('api/users/notifications')
                ->group(base_path('routes/api/users/notifications.php'));
            // Users =================================================
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
