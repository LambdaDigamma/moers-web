<?php

namespace App\Providers;

use App\Repositories\EntryRepository;
use App\Repositories\EntryRepositoryInterface;
use App\Repositories\PageRepository;
use App\Repositories\PageRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class PageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PageRepositoryInterface::class, PageRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
