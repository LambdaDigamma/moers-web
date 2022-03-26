<?php

use App\Models\Event;

test('events can be scoped only online', function () {

    Event::factory()
        ->published()
        ->create([
            'extras' => [
                'attendance_mode' => Event::ATTENDANCE_OFFLINE,
            ]
        ]);
    
    Event::factory()
        ->published()
        ->create([
            'extras' => [
                'attendance_mode' => Event::ATTENDANCE_MIXED,
            ]
        ]);

    Event::factory()
        ->published()
        ->create([
            'extras' => [
                'attendance_mode' => Event::ATTENDANCE_ONLINE,
            ]
        ]);

    expect(Event::query()->onlyOnline()->count())->toBe(1);
});

test('events can be scoped online and mixed', function () {

    Event::factory()
        ->published()
        ->create([]);

    Event::factory()
        ->published()
        ->create([
            'extras' => [
                'attendance_mode' => Event::ATTENDANCE_OFFLINE,
            ]
        ]);
    
    Event::factory()
        ->published()
        ->create([
            'extras' => [
                'attendance_mode' => Event::ATTENDANCE_MIXED,
            ]
        ]);

    Event::factory()
        ->published()
        ->create([
            'extras' => [
                'attendance_mode' => Event::ATTENDANCE_ONLINE,
            ]
        ]);

    expect(Event::query()->onlineAndMixed()->count())->toBe(2);
});

test('events can be scoped offline', function () {

    Event::factory()
        ->published()
        ->create([]);

    Event::factory()
        ->published()
        ->create([
            'extras' => [
                'attendance_mode' => Event::ATTENDANCE_OFFLINE,
            ]
        ]);
    
    Event::factory()
        ->published()
        ->create([
            'extras' => [
                'attendance_mode' => Event::ATTENDANCE_MIXED,
            ]
        ]);

    Event::factory()
        ->published()
        ->create([
            'extras' => [
                'attendance_mode' => Event::ATTENDANCE_ONLINE,
            ]
        ]);

    expect(Event::query()->offline()->count())->toBe(2);
});