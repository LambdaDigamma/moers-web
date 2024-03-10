<?php

namespace Modules\Parking\Providers;

use Closure;
use Illuminate\Support\ServiceProvider;

class ParkingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'parking');

        $this->app->register(RouteServiceProvider::class);
    }
}
