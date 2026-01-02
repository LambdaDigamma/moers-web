<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\HorizonServiceProvider::class,
    Modules\Events\Providers\EventsServiceProvider::class,
    Modules\Multimedia\Providers\MultimediaServiceProvider::class,
    Modules\News\Providers\NewsServiceProvider::class,
    Modules\Parking\Providers\ParkingServiceProvider::class,
    Modules\Waste\Providers\WasteServiceProvider::class,
];
