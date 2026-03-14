<?php

namespace Modules\Product\Providers\Stock;

use Illuminate\Support\ServiceProvider;
use Modules\Product\Interfaces\V1\Stock\StockRepositoryInterface;
use Modules\Product\Interfaces\V1\Stock\StockServiceInterface;
use Modules\Product\Providers\Auth\AuthServiceProvider;
use Modules\Product\Providers\Profile\ProfileServiceProvider;
use Modules\Product\Providers\StockType\StockTypeServiceProvider;
use Modules\Product\Repositories\V1\StockRepository;
use Modules\Product\Services\V1\StockService;

class StockServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(StockRouteServiceProvider::class);

        $this->app->bind(StockServiceInterface::class, StockService::class);
        $this->app->bind(StockRepositoryInterface::class, StockRepository::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . "/../../Database/migrations");
        $this->loadViewsFrom(__DIR__ . "/../../Views", 'address');
    }
}
