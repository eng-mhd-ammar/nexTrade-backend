<?php

namespace Modules\Favorite\Providers\Favorite;

use Illuminate\Support\ServiceProvider;
use Modules\Favorite\Interfaces\V1\Favorite\FavoriteRepositoryInterface;
use Modules\Favorite\Interfaces\V1\Favorite\FavoriteServiceInterface;
use Modules\Favorite\Providers\Auth\AuthServiceProvider;
use Modules\Favorite\Providers\Profile\ProfileServiceProvider;
use Modules\Favorite\Providers\FavoriteType\FavoriteTypeServiceProvider;
use Modules\Favorite\Repositories\V1\FavoriteRepository;
use Modules\Favorite\Services\V1\FavoriteService;

class FavoriteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(FavoriteRouteServiceProvider::class);

        $this->app->bind(FavoriteServiceInterface::class, FavoriteService::class);
        $this->app->bind(FavoriteRepositoryInterface::class, FavoriteRepository::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . "/../../Database/migrations");
        $this->loadViewsFrom(__DIR__ . "/../../Views", 'favorite');
    }
}
