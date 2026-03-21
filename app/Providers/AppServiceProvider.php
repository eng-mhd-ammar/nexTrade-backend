<?php

namespace App\Providers;

use App\Custom\CustomPaginator;
use App\Http\Exceptions\ExceptionsHandler;
use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(\Modules\Auth\Providers\User\UserServiceProvider::class);
        $this->app->register(\Modules\Address\Providers\Address\AddressServiceProvider::class);
        $this->app->register(\Modules\Product\Providers\Product\ProductServiceProvider::class);
        $this->app->register(\Modules\Category\Providers\Category\CategoryServiceProvider::class);
        $this->app->register(\Modules\Favorite\Providers\Favorite\FavoriteServiceProvider::class);

        // $this->app->bind(ClientInterface::class, function () {
        //     return new Client();
        // });

        $this->app->alias(CustomPaginator::class, LengthAwarePaginator::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
