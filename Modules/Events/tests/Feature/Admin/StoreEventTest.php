<?php

use Database\Factories\UserFactory;
use Modules\Events\Models\Event;

test('authenticated user can store an event', function () {
    $this->assertCount(0, Event::all());

    $this
        ->actingAs(UserFactory::new()->create())
        ->post(route('admin.events.store'), [
            'name' => 'New Name',
            'description' => 'An optional description',
        ])
        ->assertStatus(302);

    $event = Event::withNotPublished()->first();
    $this->assertEquals('New Name', $event->name);
    $this->assertEquals('An optional description', $event->description);
});

test('authenticated user can store an event json', function () {
    $this->assertCount(0, Event::all());

    $this
        ->actingAs(UserFactory::new()->create())
        ->postJson(route('admin.events.store'), [
            'name' => 'New Name',
            'description' => 'An optional description',
        ])
        ->assertStatus(302)
        ->assertJson([
            'name' => 'New Name',
            'description' => 'An optional description',
        ]);

    $event = Event::withNotPublished()->first();
    $this->assertEquals('New Name', $event->name);
    $this->assertEquals('An optional description', $event->description);
});
