<?php

namespace Modules\Events\Actions;

use Modules\Events\Models\Event;

class CreateMoersFestivalCollectionEvent
{

    public function execute(int $year): Event
    {
        $organisation = (new CreateMoersFestivalOrganisationIfNeeded)->execute();

        $slug = "moers-festival-$year";
        $event = Event::query()
            ->withArchived()
            ->withNotPublished()
            ->where('slug', $slug)
            ->first();

        if ($event != null) {
            return $event;
        }

        return Event::updateOrCreate([
            'slug' => $slug,
            'name' => "moers festival $year",
            'organisation_id' => $organisation->id,
        ]);
    }

}
