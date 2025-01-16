<?php

use function Pest\Laravel\getJson;

it('gets parking lots', function () {

    getJson('/api/v1/parking-areas')
        ->assertOk();

});
