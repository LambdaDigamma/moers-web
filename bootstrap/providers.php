<?php

use App\Providers\AppServiceProvider;
use App\Providers\HorizonServiceProvider;
use Modules\Events\Providers\EventsServiceProvider;
use Modules\Management\Providers\ManagementServiceProvider;
use Modules\Multimedia\Providers\MultimediaServiceProvider;
use Modules\News\Providers\NewsServiceProvider;
use Modules\Parking\Providers\ParkingServiceProvider;
use Modules\Waste\Providers\WasteServiceProvider;

return [
    AppServiceProvider::class,
    HorizonServiceProvider::class,
    EventsServiceProvider::class,
    MultimediaServiceProvider::class,
    ManagementServiceProvider::class,
    NewsServiceProvider::class,
    ParkingServiceProvider::class,
    WasteServiceProvider::class,
];
