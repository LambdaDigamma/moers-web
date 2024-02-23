<?php

use function Pest\Laravel\get;

it('can be accessed', function () {
    get('/veranstaltungen')->assertStatus(200);
});