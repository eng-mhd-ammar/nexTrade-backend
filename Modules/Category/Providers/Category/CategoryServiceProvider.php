<?php

namespace Modules\Category\Providers\Category;

use Illuminate\Support\ServiceProvider;
use Modules\Category\Interfaces\V1\Category\CategoryRepositoryInterface;
use Modules\Category\Interfaces\V1\Category\CategoryServiceInterface;
use Modules\Category\Providers\Auth\AuthServiceProvider;
use Modules\Category\Providers\Profile\ProfileServiceProvider;
use Modules\Category\Providers\CategoryType\CategoryTypeServiceProvider;
use Modules\Category\Repositories\V1\CategoryRepository;
use Modules\Category\Services\V1\CategoryService;

class CategoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(CategoryRouteServiceProvider::class);

        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . "/../../Database/migrations");
        $this->loadViewsFrom(__DIR__ . "/../../Views", 'category');
    }
}
