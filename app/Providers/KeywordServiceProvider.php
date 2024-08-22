<?php

namespace App\Providers;

use App\Models\Keywords;
use App\Repositories\KeywordRepositoryImplementation;
use App\Repositories\KeywordRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class KeywordServiceProvider extends ServiceProvider
{
    public $timestamp = [
        Keywords::class => Keywords::class
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(KeywordRepositoryInterface::class, function($app)  {
            return new KeywordRepositoryImplementation($app->make(Keywords::class));
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
