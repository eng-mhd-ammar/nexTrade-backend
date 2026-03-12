<?php

namespace Modules\Auth\Providers\Auth;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Interfaces\V1\Auth\AuthServiceInterface;
use Modules\Auth\Providers\Profile\ProfileServiceProvider;
use Modules\Auth\Providers\Role\RoleServiceProvider;
use Modules\Auth\Providers\Socialite\SocialiteServiceProvider;
use Modules\Auth\Providers\User\UserServiceProvider;
use Modules\Auth\Services\V1\AuthService;

class AuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(AuthRouteServiceProvider::class);

        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    public function boot()
    {
    }
}
