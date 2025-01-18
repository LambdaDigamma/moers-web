<?php

namespace Modules\News\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\News\Models\Feed;
use Modules\News\Models\Post;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'News';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        Route::bind('anyfeed', function ($id) {
            return Feed::query()
                ->withTrashed()
                ->findOrFail($id);
        });

        Route::bind('anypost', function ($id) {
            return Post::query()
                ->with(['page', 'page.blocks'])
                ->withNotPublished()
                ->withTrashed()
                ->withArchived()
                ->findOrFail($id);
        });

        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')->group(module_path($this->name, '/routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware('api')->prefix('api')->name('api.')->group(module_path($this->name, '/routes/api.php'));
    }
}
