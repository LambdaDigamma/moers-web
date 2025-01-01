<?php

namespace Modules\Organisation\Providers;

use Closure;
use Illuminate\Support\ServiceProvider;

class OrganisationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'organisation');

        $this->app->register(RouteServiceProvider::class);
    }
}
