<?php

namespace Modules\Parking\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends BaseRouteServiceProvider
{

    public function boot()
    {
        $this->routes(function () {

            Route::middleware('web')
                ->group(__DIR__ . '/../routes/web.php');

            Route::middleware('api')
                ->group(__DIR__ . '/../routes/api.php');

        });
    }

}
