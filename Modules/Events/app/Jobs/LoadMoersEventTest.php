<?php

use Modules\Events\Jobs\LoadMoersEvent;

it('loads', function () {

    LoadMoersEvent::dispatch("https://www.moers.de/jsonapi/node/event/6ef4c329-5062-4d2e-a569-59fe5e952cd6?resourceVersion=id%3A33747");

});
