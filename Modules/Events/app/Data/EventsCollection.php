<?php

namespace Modules\Events\Data;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class EventsCollection extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public Carbon $publishMetaAt,
        public bool $isPreview = false
    ) {}

    public static function base()
    {
        return collect([
            new EventsCollection(id: 6, name: 'festival24', publishMetaAt: Carbon::parse('05-05-2022 12:00:00', 'Europe/Berlin'), isPreview: true),
            new EventsCollection(id: 5, name: 'festival23', publishMetaAt: Carbon::parse('05-05-2022 12:00:00', 'Europe/Berlin')),
            new EventsCollection(id: 4, name: 'festival22', publishMetaAt: Carbon::parse('05-05-2022 12:00:00', 'Europe/Berlin')),
            new EventsCollection(id: 3, name: 'improviser22', publishMetaAt: Carbon::parse('01-01-2022', 'Europe/Berlin')),
            new EventsCollection(id: 2, name: 'festival21', publishMetaAt: Carbon::parse('01-01-2022', 'Europe/Berlin')),
            new EventsCollection(id: 1, name: 'improviser21', publishMetaAt: Carbon::parse('01-01-2022', 'Europe/Berlin')),
        ]);
    }
}
