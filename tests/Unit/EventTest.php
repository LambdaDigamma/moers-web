<?php

use App\Models\Event;
use Illuminate\Support\Carbon;

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

test('date duration can be added', function () {

    $event = Event::factory()->published()->create([
        'start_date' => Carbon::parse('2022-03-20 00:00:00'), 
        'end_date' => Carbon::parse('2022-03-30 00:00:00')
    ]);

    $e = Event::query()
        ->withDaysDuration()
        ->withMinutesDuration()
        ->where('id', $event->id)
        ->first();

    expect($e->days_duration)->toBe(10)
        ->and($e->minutes_duration)->toBe(14400);
});

test('date duration null when no dates are given', function () {

    $event = Event::factory()->published()->create([
        'start_date' => null, 
        'end_date' => null,
    ]);

    $e = Event::query()
        ->withDaysDuration()
        ->withMinutesDuration()
        ->where('id', $event->id)
        ->first();

    expect($e->days_duration)->toBe(null)
        ->and($e->minutes_duration)->toBe(null);
});

test('date duration null when only start_date is given', function () {

    $event = Event::factory()->published()->create([
        'start_date' => Carbon::parse('2022-03-10 00:00:00'), 
        'end_date' => null,
    ]);

    $e = Event::query()
        ->withDaysDuration()
        ->withMinutesDuration()
        ->where('id', $event->id)
        ->first();

    expect($e->days_duration)->toBe(null)
        ->and($e->minutes_duration)->toBe(null);
});

test('scope only long term events with default duration', function () {

    Event::factory()->published()->create([
        'start_date' => Carbon::parse('2022-04-10 00:00:00'), 
        'end_date' => Carbon::parse('2022-04-10 01:00:00'),
    ]);

    $event = Event::factory()->published()->create([
        'start_date' => Carbon::parse('2021-04-11 00:00:00'), 
        'end_date' => Carbon::parse('2022-04-13 22:00:00'),
    ]);

    expect(Event::query()->onlyLongTermEvents()->get())
        ->count()->toBe(1);

});

test('scope without long term events', function () {

    Event::factory()->published()->create([
        'start_date' => Carbon::parse('2022-04-10 00:00:00'), 
        'end_date' => Carbon::parse('2022-04-10 01:00:00'),
    ]);

    Event::factory()->published()->create([
        'start_date' => Carbon::parse('2022-04-11 10:00:00'), 
        'end_date' => Carbon::parse('2022-04-12 18:00:00'),
    ]);

    Event::factory()->published()->create([
        'start_date' => Carbon::parse('2021-04-11 00:00:00'), 
        'end_date' => Carbon::parse('2022-04-13 22:00:00'),
    ]);

    expect(Event::query()->withoutLongTermEvents()->get())
        ->count()->toBe(2);

});