<?php

namespace Modules\News\Providers;

use Closure;
use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'news');

        $this->app->register(RouteServiceProvider::class);
    }
}
