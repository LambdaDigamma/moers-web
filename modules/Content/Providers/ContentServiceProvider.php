<?php

namespace Modules\Content\Providers;

use Closure;
use Illuminate\Support\ServiceProvider;

class ContentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'event');

        $this->app->register(RouteServiceProvider::class);
    }
}
