<?php

use Carbon\Carbon;
use Modules\Events\Exceptions\InvalidLink;
use Modules\Events\Models\Event;
use Tests\TestCase;

//
// class EventTest extends TestCase
// {
//    use DatabaseMigrations;
//    use RefreshDatabase;

test('scope active', function () {

    $activeEventStartEnd = Event::factory()
        ->published()
        ->activeStartEnd()
        ->create();

    $activeEventInDeadline = Event::factory()
        ->published()
        ->activeStart()
        ->create();

    $upcomingStartEvent = Event::factory()
        ->published()
        ->upcomingStart()
        ->create();

    $activeEventsDatabase = Event::active()->pluck('id');

    expect($activeEventsDatabase)->toContain($activeEventStartEnd->id);
    expect($activeEventsDatabase)->toContain($activeEventInDeadline->id);
    expect($activeEventsDatabase)->not->toContain($upcomingStartEvent->id);

});

test('scope published', function () {
    $publishedEvents = Event::factory()
        ->count(3)
        ->published()
        ->create();

    $notPublishedEvents = Event::factory()
        ->count(3)
        ->notPublished()
        ->create();

    $events = Event::query()->pluck('id');

    expect($events)->toContain($publishedEvents->first()->id);
    expect($events)->not->toContain($notPublishedEvents->first()->id);
});

test('scope today', function () {
    $eventYesterday = Event::factory()
        ->published()
        ->create([
            'start_date' => Carbon::now()->addDays(-1),
        ]);

    $eventToday = Event::factory()
        ->published()
        ->create([
            'start_date' => Carbon::now(),
        ]);

    $eventTomorrow = Event::factory()
        ->published()
        ->create([
            'start_date' => Carbon::now()->addDays(1),
        ]);

    $scopedEventsDatabase = Event::today()->pluck('id');

    expect($scopedEventsDatabase)->not->toContain($eventYesterday->id);
    expect($scopedEventsDatabase)->toContain($eventToday->id);
    expect($scopedEventsDatabase)->not->toContain($eventTomorrow->id);
});

test('scope upcoming today', function () {
    $eventPreviousDay = Event::factory()
        ->published()
        ->create([
            'start_date' => Carbon::now()->addDays(-1),
        ]);

    $eventAlreadyActive = Event::factory()
        ->published()
        ->create([
            'start_date' => Carbon::now()->addMinutes(-60),
        ]);

    $eventUpcomingToday = Event::factory()
        ->published()
        ->upcomingToday()
        ->create();

    $eventTomorrow = Event::factory()
        ->published()
        ->create([
            'start_date' => Carbon::now()->addDay(),
        ]);

    $scopedEventsDatabase = Event::upcomingToday()->pluck('id');

    $this->assertFalse($scopedEventsDatabase->contains($eventPreviousDay->id));
    $this->assertFalse($scopedEventsDatabase->contains($eventAlreadyActive->id));
    $this->assertTrue($scopedEventsDatabase->contains($eventUpcomingToday->id));
    $this->assertFalse($scopedEventsDatabase->contains($eventTomorrow->id));
});

test('scope next days', function () {

    $eventPreviousDay = Event::factory()
        ->published()
        ->create([
            'start_date' => Carbon::now()->addDays(-1),
        ]);

    $eventAlreadyActive = Event::factory()
        ->published()
        ->create([
            'start_date' => Carbon::now()->addMinutes(-60),
        ]);

    $eventUpcomingToday = Event::factory()
        ->published()
        ->upcomingToday()
        ->create();

    $eventTomorrow = Event::factory()
        ->published()
        ->create([
            'start_date' => Carbon::now()->addDay(),
        ]);

    $scopedEventsDatabase = Event::nextDays()->pluck('id');

    $this->assertFalse($scopedEventsDatabase->contains($eventPreviousDay->id));
    $this->assertFalse($scopedEventsDatabase->contains($eventAlreadyActive->id));
    $this->assertFalse($scopedEventsDatabase->contains($eventUpcomingToday->id));
    $this->assertTrue($scopedEventsDatabase->contains($eventTomorrow->id));

});

test('scope sort chronologically', function () {
    $eventUpcomingToday = Event::factory()
        ->published()
        ->upcomingToday()
        ->create();

    $eventTomorrow = Event::factory()
        ->published()
        ->create([
            'start_date' => Carbon::now()->addDay(),
        ]);

    $eventPreviousDay = Event::factory()
        ->published()
        ->create([
            'start_date' => Carbon::now()->addDays(-1),
        ]);

    $eventAlreadyActive = Event::factory()
        ->published()
        ->create([
            'start_date' => Carbon::now()->addMinutes(-60),
        ]);

    $eventNoDate = Event::factory()
        ->published()
        ->create([
            'start_date' => null,
        ]);

    $scopedEventsDatabase = Event::query()
        ->withNotPublished()
        ->chronological()
        ->get()
        ->pluck('id');

    $this->assertEquals($scopedEventsDatabase->toArray(), collect([
        $eventPreviousDay->id,
        $eventAlreadyActive->id,
        $eventUpcomingToday->id,
        $eventTomorrow->id,
        $eventNoDate->id,
    ])->toArray());
});

test('Ics export active start', function () {
    $event = Event::factory()
        ->published()
        ->activeStart()
        ->create();

    $this->assertStringStartsWith('data:text/calendar;charset=utf8;base64,', $event->ics());
});

test('ics export fails no dates', function () {
    $event = Event::factory()
        ->published()
        ->create([
            'start_date' => null,
            'end_date' => null,
        ]);

    $this->expectException(InvalidLink::class);

    $this->assertStringStartsWith('data:text/calendar;charset=utf8;base64,', $event->ics());
});

test('publish', function () {
    $event = Event::factory()
        ->upcomingToday()
        ->notPublished()
        ->create();

    $this->assertNull($event->published_at);
    $event->publish();
    $this->assertNotNull($event->published_at);
});

test('unpublish', function () {
    $event = Event::factory()
        ->upcomingToday()
        ->published()
        ->create();

    $this->assertNotNull($event->published_at);
    $event->unpublish();
    $this->assertNull($event->published_at);
});

test('setting mixed attendance', function () {
    $event = Event::factory()
        ->upcomingToday()
        ->published()
        ->create([
            'extras' => [],
            'attendance_mode' => 'mixed',
        ]);

    $this->assertEquals('mixed', $event->attendance_mode);
});

test('setting online attendance', function () {
    $event = Event::factory()
        ->upcomingToday()
        ->published()
        ->create([
            'attendance_mode' => 'online',
        ]);

    $this->assertEquals('online', $event->attendance_mode);
});

test('setting offline attendance', function () {
    $event = Event::factory()
        ->upcomingToday()
        ->published()
        ->create([
            'attendance_mode' => 'offline',
        ]);

    $this->assertEquals('offline', $event->attendance_mode);
});

test('setting unknown attendance fails', function () {
    $this->expectException(Exception::class);
    $this->expectExceptionMessage('Attendance mode unknown. Only offline, online and mixed is allowed.');
    $event = Event::factory()
        ->upcomingToday()
        ->published()
        ->create();
    $event->attendance_mode = 'something-else';
});

test('collection scopes', function () {
    $eventsWithCollection = Event::factory()
        ->times(3)
        ->published()
        ->create([
            'extras' => [
                'collection' => 'collection-1',
            ],
        ]);

    $eventsWithoutCollection = Event::factory()
        ->times(4)
        ->published()
        ->create([
            'extras' => [],
        ]);

    $this->assertEquals(7, Event::query()->count());
    $this->assertEquals(4, Event::query()->noCollection()->count());
    $this->assertEquals(3, Event::query()->collection('collection-1')->count());
    $this->assertEquals(0, Event::query()->collection('collection-2')->count());
});

test('filter scope', function () {

    $eventsWithCollection = Event::factory()
        ->times(3)
        ->published()
        ->create([
            'extras' => [
                'collection' => 'collection-1',
            ],
        ]);

    $eventsWithCollection2 = Event::factory()
        ->times(2)
        ->published()
        ->create([
            'extras' => [
                'collection' => 'collection-2',
            ],
        ]);

    $eventsWithoutCollection = Event::factory()
        ->times(4)
        ->published()
        ->create([
            'extras' => [],
        ]);

    $countCollection2 = Event::query()
        ->filter(['collection' => 'collection-2'])
        ->count();

    $countCollection1 = Event::query()
        ->filter(['collection' => 'collection-1'])
        ->count();

    $this->assertEquals(2, $countCollection2);
    $this->assertEquals(3, $countCollection1);

});

test('duration no start date', function () {
    $event = Event::factory()->create([
        'start_date' => null,
        'end_date' => null,
    ]);
    $this->assertNull($event->duration);
});

test('duration only start date', function () {
    $event = Event::factory()->create([
        'start_date' => Carbon::now()->addDay(),
        'end_date' => null,
    ]);
    $this->assertEquals(30, $event->duration);
});

test('duration 55 minutes with start and end date', function () {
    $event = Event::factory()->create([
        'start_date' => Carbon::now()->addMinutes(45),
        'end_date' => Carbon::now()->addMinutes(100),
    ]);
    $this->assertEquals(55, $event->duration);
});

test('date casts', function () {
    $event = Event::factory()->create([
        'start_date' => Carbon::now()->addMinutes(45),
    ]);

    $this->assertEquals($event->fresh()->start_date::class, "Illuminate\Support\Carbon");
});
