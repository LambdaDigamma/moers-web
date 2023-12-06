<?php

use function Pest\Laravel\get;

it('can be accessed', function () {

    get('/')->assertStatus(200);
    get('/home')->assertStatus(200);

});