<?php

namespace Modules\Auth\Providers\UserType;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Interfaces\V1\UserType\UserTypeRepositoryInterface;
use Modules\Auth\Interfaces\V1\UserType\UserTypeServiceInterface;
use Modules\Auth\Repositories\V1\UserTypeRepository;
use Modules\Auth\Services\V1\UserTypeService;

class UserTypeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(UserTypeRouteServiceProvider::class);

        $this->app->bind(UserTypeServiceInterface::class, UserTypeService::class);
        $this->app->bind(UserTypeRepositoryInterface::class, UserTypeRepository::class);
    }

    public function boot()
    {
        //
    }
}
