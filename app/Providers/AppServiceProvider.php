<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
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
        //
        //        Route::bind('anypage', function ($id) {
        //            return Page::query()
        //                ->withNotPublished()
        //                ->with(['blocks' => function ($query) {
        //                    $query
        //                        ->withNotPublished()
        //                        ->with('media')
        //                        ->withHidden();
        //                }])
        //                // ->with('blocks')
        //                ->withTrashed()
        //                ->withArchived()
        //                ->findOrFail($id);
        //        });
        //
        //        Route::bind('previewpage', function ($id) {
        //            return Page::query()
        //                ->withNotPublished()
        //                ->with(['blocks' => function ($query) {
        //                    $query
        //                        ->withNotPublished()
        //                        ->withExpired()
        //                        ->with('media');
        //                }])
        //                // ->with('blocks')
        //                ->withTrashed()
        //                ->withArchived()
        //                ->findOrFail($id);
        //        });
        //
        //        Route::bind('anyblock', function ($id) {
        //            return PageBlock::query()
        //                // ->with(['media', 'page'])
        //                ->with(['media', 'page' => function ($query) {
        //                    $query
        //                        ->withNotPublished()
        //                        ->withArchived()
        //                        ->withTrashed();
        //                }])
        //                ->withExpired()
        //                ->withNotPublished()
        //                ->withHidden()
        //                ->withTrashed()
        //                ->findOrFail($id);
        //        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
