<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\HorizonServiceProvider::class,
    \Modules\Events\Providers\EventsServiceProvider::class,
    \Modules\Waste\Providers\WasteServiceProvider::class,
    \Modules\Parking\Providers\ParkingServiceProvider::class,
    \Modules\News\Providers\NewsServiceProvider::class,
];
