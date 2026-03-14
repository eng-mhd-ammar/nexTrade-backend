<?php

namespace Modules\Product\Providers\Product;

use Illuminate\Support\ServiceProvider;
use Modules\Product\Interfaces\V1\Product\ProductRepositoryInterface;
use Modules\Product\Interfaces\V1\Product\ProductServiceInterface;
use Modules\Product\Providers\Auth\AuthServiceProvider;
use Modules\Product\Providers\Profile\ProfileServiceProvider;
use Modules\Product\Providers\ProductType\ProductTypeServiceProvider;
use Modules\Product\Repositories\V1\ProductRepository;
use Modules\Product\Services\V1\ProductService;
use Modules\Product\Providers\Stock\StockServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(ProductRouteServiceProvider::class);

        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

        $this->app->register(StockServiceProvider::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . "/../../Database/migrations");
        $this->loadViewsFrom(__DIR__ . "/../../Views", 'product');
    }
}
