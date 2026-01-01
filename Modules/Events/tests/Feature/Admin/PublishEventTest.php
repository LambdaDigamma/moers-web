<?php

use Database\Factories\UserFactory;
use Illuminate\Support\Carbon;
use Modules\Events\Models\Event;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

test('unpublished event can be published now', function () {
    actingAs(UserFactory::new()->create());
    $event = Event::factory()->create();
    expect($event->published_at)->toBeNull();

    postJson("/admin/events/{$event->id}/publish")->assertStatus(200);
    expect(Event::find($event->id)->published_at)->not->toBeNull();
});

test('unpublished event can be published at specific time', function () {
    actingAs(UserFactory::new()->create());
    $event = Event::factory()->create();
    expect($event->published_at)->toBeNull();

    $publishAt = Carbon::now()->addMinutes(60);

    postJson("/admin/events/{$event->id}/publish", [
        'published_at' => $publishAt->toDateTimeString(),
    ])->assertStatus(200);
    expect(Event::query()->withNotPublished()->find($event->id)->published_at->toDateTimeString())
        ->toBe($publishAt->toDateTimeString());
});

test('published event can be unpublished', function () {
    actingAs(UserFactory::new()->create());
    $event = Event::factory()->published()->create();
    expect($event->published_at)->not->toBeNull();

    postJson("/admin/events/{$event->id}/unpublish")->assertStatus(200);
    expect(Event::query()->withNotPublished()->find($event->id)->published_at)
        ->toBeNull();
});
