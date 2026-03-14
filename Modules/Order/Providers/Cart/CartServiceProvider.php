<?php

namespace Modules\Order\Providers\Cart;

use Illuminate\Support\ServiceProvider;
use Modules\Order\Interfaces\V1\Cart\CartRepositoryInterface;
use Modules\Order\Interfaces\V1\Cart\CartServiceInterface;
use Modules\Order\Providers\Auth\AuthServiceProvider;
use Modules\Order\Providers\Profile\ProfileServiceProvider;
use Modules\Order\Providers\CartType\CartTypeServiceProvider;
use Modules\Order\Repositories\V1\CartRepository;
use Modules\Order\Services\V1\CartService;

class CartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(CartRouteServiceProvider::class);

        $this->app->bind(CartServiceInterface::class, CartService::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . "/../../Database/migrations");
        $this->loadViewsFrom(__DIR__ . "/../../Views", 'cart');
    }
}
