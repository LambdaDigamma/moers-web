<?php

use Modules\Events\Models\Event;

test('test event ld (start, end, description, online)', function () {
    $event = Event::factory()->published()->create([
        'name' => 'My event',
        'description' => 'This is a description',
        'start_date' => '2021-05-25 19:30:00',
        'end_date' => '2021-05-25 21:00:00',
        'extras' => [
            'attendance_mode' => 'online',
        ],
    ]);

    expect($event->jsonLd())->toMatchArray([
        '@type' => 'Event',
        'name' => 'My event',
        'startDate' => '2021-05-25T19:30:00+00:00',
        'endDate' => '2021-05-25T21:00:00+00:00',
        'eventStatus' => 'https://schema.org/EventScheduled',
        'eventAttendanceMode' => 'https://schema.org/OnlineEventAttendanceMode',
        'description' => 'This is a description',
    ]);
});

test('test event ld (start, end, offline, cancelled)', function () {
    $event = Event::factory()->published()->create([
        'name' => 'My event',
        'start_date' => '2021-05-25 19:30:00',
        'end_date' => '2021-05-25 21:00:00',
        'cancelled_at' => now(),
        'extras' => [
            'attendance_mode' => 'offline',
        ],
    ]);

    expect($event->jsonLd())->toMatchArray([
        '@type' => 'Event',
        'name' => 'My event',
        'startDate' => '2021-05-25T19:30:00+00:00',
        'endDate' => '2021-05-25T21:00:00+00:00',
        'eventStatus' => 'https://schema.org/EventCancelled',
        'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
    ]);
});

test('test event ld (start, end, mixed, cancelled)', function () {
    $event = Event::factory()->published()->create([
        'name' => 'My event',
        'start_date' => '2021-05-25 19:30:00',
        'end_date' => '2021-05-25 21:00:00',
        'cancelled_at' => now(),
        'extras' => [
            'attendance_mode' => 'mixed',
        ],
    ]);

    expect($event->jsonLd())->toMatchArray([
        '@type' => 'Event',
        'name' => 'My event',
        'startDate' => '2021-05-25T19:30:00+00:00',
        'endDate' => '2021-05-25T21:00:00+00:00',
        'eventStatus' => 'https://schema.org/EventCancelled',
        'eventAttendanceMode' => 'https://schema.org/MixedEventAttendanceMode',
    ]);
});
