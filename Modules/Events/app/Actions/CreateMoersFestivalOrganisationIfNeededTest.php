<?php

use Modules\Events\Actions\CreateMoersFestivalOrganisationIfNeeded;

it('creates a new organisation if it does not exist', function () {

    $organisation = (new CreateMoersFestivalOrganisationIfNeeded)->execute();

    expect($organisation)
        ->name->toBe('moers festival')
        ->slug->toBe('moers-festival');

});
