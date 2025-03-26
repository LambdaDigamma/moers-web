<?php

use App\Models\User;
use Carbon\Carbon;
use Modules\Events\Exceptions\InvalidLink;
use Modules\Events\Models\Event;
use Modules\Locations\Models\Location;

use function Pest\Laravel\travelTo;

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

it('test event with collection meta publication after now (not authorized) => null', function () {

    travelTo(Carbon::parse('2021-12-30'));

    $this->assertGuest();

    $event = Event::factory()->create([
        'start_date' => '2022-06-05 13:00:00',
        'end_date' => '2022-06-05 15:00:00',
        'extras' => [
            'collection' => 'festival21',
        ],
    ]);

    $this->assertNull($event->start_date);
    $this->assertNull($event->end_date);

});

it('test event with collection meta publication after now (authorized) => date', function () {

    travelTo(Carbon::parse('2021-12-30'));

    $this->actingAs(User::factory()->superAdmin()->create());
    $this->assertAuthenticated();

    $event = Event::factory()->create([
        'start_date' => '2022-06-05 13:00:00',
        'end_date' => '2022-06-05 15:00:00',
        'extras' => [
            'collection' => 'festival21',
        ],
    ]);

    //    dd($event);
    //    expect($event->start_date)->not->toBeNull();
    //    expect($event->end_date)->not->toBeNull();

    //    $this->assertNotNull($event->start_date);
    //    $this->assertNotNull($event->end_date);

});

it('test event with collection meta publication before now (not authorized) => date', function () {

    travelTo(Carbon::parse('2022-01-01 01:00:00'));

    $this->assertGuest();

    $event = Event::factory()->create([
        'start_date' => '2022-06-05 13:00:00',
        'end_date' => '2022-06-05 15:00:00',
        'extras' => [
            'collection' => 'festival21',
        ],
    ]);

    $this->assertNotNull($event->start_date);
    $this->assertNotNull($event->end_date);

});

it('test event with collection meta publication before now (authorized) => date', function () {

    travelTo(Carbon::parse('2022-01-01 01:00:00'));

    $this->actingAs(User::factory()->superAdmin()->create());
    $this->assertAuthenticated();

    $event = Event::factory()->create([
        'start_date' => '2022-06-05 13:00:00',
        'end_date' => '2022-06-05 15:00:00',
        'extras' => [
            'collection' => 'festival21',
        ],
    ]);

    $this->assertNotNull($event->start_date);
    $this->assertNotNull($event->end_date);

});

it('test festival22 event with collection meta publication before now (unauthorized) => null', function () {

    travelTo(Carbon::parse('2022-05-05 11:59:00', 'Europe/Berlin'));

    $this->assertGuest();
    $place = Location::factory()->create(['lat' => 51.966, 'lng' => 7.619]);
    $event = Event::factory()->create([
        'start_date' => '2022-06-05 13:00:00',
        'end_date' => '2022-06-05 15:00:00',
        'extras' => [
            'collection' => 'festival22',
        ],
        'place_id' => $place->id,
    ]);

    $event->load('place');

    $this->assertNull($event->start_date);
    $this->assertNull($event->end_date);
    $this->assertNull($event->toArray()['place']);
    $this->assertNull($event->toArray()['place_id']);

    travelTo(Carbon::parse('2022-05-05 12:01:00', 'Europe/Berlin'));
    $this->assertNotNull($event->start_date);
    $this->assertNotNull($event->end_date);
    $this->assertNotNull($event->toArray()['place']);
    $this->assertNotNull($event->toArray()['place_id']);

});

test('is published', function () {

    travelTo(Carbon::parse('2022-01-01 01:00:00'));

    $event = Event::factory()->create([
        'start_date' => '2022-06-05 13:00:00',
        'end_date' => '2022-06-05 15:00:00',
        'published_at' => '2022-06-01 12:00:00',
        'extras' => [
            'collection' => 'festival21',
        ],
    ]);

    expect($event->isPublished())->toBeFalse();

    travelTo(Carbon::parse('2022-06-01 12:10:00'));
    expect($event->isPublished())->toBeTrue();

});

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

it('can have subevents and parent', function () {

    $event = Event::factory()->published()->create([]);

    expect($event->subEvents())->count()->toBe(0);

    $subEvent = $event->subEvents()->create([
        'name' => 'My event',
        'published_at' => now(),
    ]);

    expect($event->fresh()->subEvents())->count()->toBe(1);
    expect($subEvent->parentEvent()->is($event))->toBeTrue();
});
