<?php

namespace Modules\Rubbish\Providers;

use Closure;
use Illuminate\Support\ServiceProvider;

class RubbishServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'rubbish');

        $this->app->register(RouteServiceProvider::class);
    }
}
