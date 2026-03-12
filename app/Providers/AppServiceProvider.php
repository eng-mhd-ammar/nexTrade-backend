<?php

namespace App\Providers;

use App\Custom\CustomPaginator;
use GuzzleHttp\Client;
use Psr\Http\Client\ClientInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(\Modules\Auth\Providers\User\UserServiceProvider::class);

        $this->app->bind(ClientInterface::class, function () {
            return new Client();
        });

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
