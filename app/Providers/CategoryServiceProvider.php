<?php

namespace App\Providers;

use App\Models\Categories;
use App\Repositories\CategoryRepositoryImplementation;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    public $singletons = [
        Categories::class => Categories::class
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CategoryRepositoryInterface::class, function($app)  {
            return new CategoryRepositoryImplementation($app->make(Categories::class)); 
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
