<?php

namespace Modules\Auth\Providers\Profile;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Interfaces\V1\Profile\ProfileRepositoryInterface;
use Modules\Auth\Interfaces\V1\Profile\ProfileServiceInterface;
use Modules\Auth\Repositories\V1\ProfileRepository;
use Modules\Auth\Services\V1\ProfileService;

class ProfileServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(ProfileRouteServiceProvider::class);

        $this->app->bind(ProfileServiceInterface::class, ProfileService::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
    }

    public function boot()
    {
        //
    }
}
