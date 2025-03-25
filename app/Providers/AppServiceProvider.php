<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\PageBlock;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Route::bind('anyuser', function ($id) {
            return User::query()
                ->findOrFail($id);
        });

        //        Route::bind('anyplace', function ($id) {
        //            return Place::query()
        //                ->withTrashed()
        //                ->findOrFail($id);
        //        });

        Route::bind('anypage', function ($id) {
            return Page::query()
                ->withNotPublished()
                ->with(['blocks' => function ($query) {
                    $query
                        ->withNotPublished()
                        ->with('media')
                        ->withHidden();
                }])
                ->withTrashed()
                ->withArchived()
                ->findOrFail($id);
        });

        Route::bind('anyblock', function ($id) {
            return PageBlock::query()
                ->with(['media', 'page' => function ($query) {
                    $query
                        ->withNotPublished()
                        ->withArchived()
                        ->withTrashed();
                }])
                ->withExpired()
                ->withNotPublished()
                ->withHidden()
                ->withTrashed()
                ->findOrFail($id);
        });
    }

    public function boot(): void
    {
        $this->configureMacros();
    }

    protected function configureMacros(): void
    {
        Blueprint::macro('hiddenAt', function ($column = 'hidden_at', $precision = 0) {
            return $this->timestamp($column, $precision)->nullable();
        });
    }
}
