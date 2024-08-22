<?php

namespace App\Providers;

use App\Models\Chapters;
use App\Repositories\ChapterRepositoryImplementation;
use App\Repositories\ChapterRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class ChapterServiceProvider extends ServiceProvider
{
  public $singletons = [
    Chapters::class => Chapters::class
  ];
  /**
   * Register services.
   */
  public function register(): void
  {
    $this->app->singleton(ChapterRepositoryInterface::class, function ($app) {
      return new ChapterRepositoryImplementation($app->make(Chapters::class));
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
