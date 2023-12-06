<?php

namespace App\Providers;

use App\Repositories\DatasetRepository;
use App\Repositories\DatasetRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class DatasetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DatasetRepositoryInterface::class, DatasetRepository::class);
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
