<?php

namespace Modules\Address\Providers\Address;

use Illuminate\Support\ServiceProvider;
use Modules\Address\Interfaces\V1\Address\AddressRepositoryInterface;
use Modules\Address\Interfaces\V1\Address\AddressServiceInterface;
use Modules\Address\Providers\Auth\AuthServiceProvider;
use Modules\Address\Providers\Profile\ProfileServiceProvider;
use Modules\Address\Providers\AddressType\AddressTypeServiceProvider;
use Modules\Address\Repositories\V1\AddressRepository;
use Modules\Address\Services\V1\AddressService;

class AddressServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(AddressRouteServiceProvider::class);

        $this->app->bind(AddressServiceInterface::class, AddressService::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . "/../../Database/migrations");
        $this->loadViewsFrom(__DIR__ . "/../../Views", 'address');
    }
}
