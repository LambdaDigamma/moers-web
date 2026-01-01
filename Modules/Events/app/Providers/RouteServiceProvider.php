<?php

namespace Modules\Events\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Events\Models\Event;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'Events';

    public function boot(): void
    {
        parent::boot();
    }

    public function map(): void
    {
        Route::bind('anyevent', function ($id) {
            return Event::query()
                ->withTrashed()
                ->withNotPublished()
                ->withArchived()
                ->findOrFail($id);
        });

        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware('web')->group(module_path($this->name, '/routes/web.php'));
    }

    protected function mapApiRoutes(): void
    {
        Route::middleware('api')->prefix('api')->name('api.')->group(module_path($this->name, '/routes/api.php'));
    }
}
