<?php

namespace Modules\Events\Actions;

use Modules\Events\Models\Event;

class CreateMoersFestivalCollectionEvent
{

    public function execute(int $year): Event
    {
        $event = Event::updateOrCreate([
            'slug' => "moers-festival-$year"
        ], [
            'name' => "moers festival $year",
        ]);

        return $event;
    }

}
