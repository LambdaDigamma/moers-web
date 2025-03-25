<?php

namespace Modules\Events\Actions;

use Modules\Management\Models\Organisation;

class CreateMoersFestivalOrganisationIfNeeded
{

    public function execute(): Organisation
    {
        $organisation = Organisation::query()->where('slug', 'moers-festival')->first();

        if ($organisation == null) {
            $organisation = Organisation::create([
                'name' => 'moers festival',
                'slug' => 'moers-festival',
                'description' => 'Jazzfestival für Musik, Miteinander, Freysinn und: Klangfriede!',
            ]);
        }

        return $organisation;
    }

}
