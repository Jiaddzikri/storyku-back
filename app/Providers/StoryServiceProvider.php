<?php

namespace App\Providers;

use App\Models\Stories;
use App\Repositories\StoryRepositoryImplementation;
use App\Repositories\StoryRepsoitoryInterface;
use Illuminate\Support\ServiceProvider;

class StoryServiceProvider extends ServiceProvider
{
    public $singletons = [
        Stories::class => Stories::class
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(StoryRepsoitoryInterface::class, function ($app) {
            return new StoryRepositoryImplementation($app->make(Stories::class));
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
