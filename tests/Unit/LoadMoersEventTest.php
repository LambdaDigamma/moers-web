<?php

use App\Jobs\LoadMoersEvent;

test('it works', function () {

    Queue::fake();

    LoadMoersEvent::dispatchSync('https://www.moers.de/jsonapi/node/event/498b9497-521e-419f-9e73-519ac219edf4?resourceVersion=id%3A15917');

    expect(true)->toBeTrue();

});
