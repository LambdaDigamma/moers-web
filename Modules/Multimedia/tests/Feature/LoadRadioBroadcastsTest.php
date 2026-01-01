<?php

test('load radio entries', function () {

    $this->artisan('radio-broadcasts:load')
        ->expectsOutput('Loading radio broadcasts...')
        ->expectsOutput('Created or updated broadcasts.')
        ->assertExitCode(0);

});
