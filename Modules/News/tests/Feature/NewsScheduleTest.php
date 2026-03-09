<?php

use Illuminate\Console\Scheduling\Schedule;

it('schedules the external post import command', function () {
    $events = collect(app(Schedule::class)->events());

    expect($events->contains(function ($event) {
        return str_contains($event->command, 'posts:import-external');
    }))->toBeTrue();
});
