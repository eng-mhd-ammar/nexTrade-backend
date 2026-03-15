<?php

namespace Modules\Category\Providers\Category;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Modules\Category\Controllers\V1\CategoryController;

class CategoryRouteServiceProvider extends RouteServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            Route::middleware('api')
                ->controller(CategoryController::class)
                ->prefix('api/v1/category')
                ->name('category.')
                ->group(__DIR__ . '/../../Routes/V1/category.php');
        });
    }
}
