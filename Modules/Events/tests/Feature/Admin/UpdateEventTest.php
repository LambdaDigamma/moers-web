<?php

use Database\Factories\UserFactory;
use Modules\Events\Models\Event;

test('authenticated users can update an event', function () {
    $this->assertCount(0, Event::all());

    $admin = UserFactory::new()->create();
    $event = Event::factory()->create(['name' => 'Initial name']);

    $this->assertEquals($event->name, 'Initial name');
    $this->assertNull($event->extras->get('collection'));

    $response = $this->actingAs($admin)->put(route('admin.events.update', $event), [
        'name' => 'New Name',
        'collection' => 'Some collection',
    ]);

    tap(Event::withNotPublished()->first(), function ($updatedEvent) use ($response) {
        $this->assertEquals('New Name', $updatedEvent->name);
        $this->assertEquals('Some collection', $updatedEvent->extras?->get('collection'));
        $response->assertRedirect();
    });
});

test('authenticated users can update an event remove collection', function () {

    $this->assertCount(0, Event::all());

    $admin = UserFactory::new()->create();
    $event = Event::factory()->create([
        'name' => 'Some name',
        'extras' => ['collection' => 'Festival'],
    ]);

    $this->assertEquals('Some name', $event->name);
    $this->assertEquals('Festival', $event->extras->get('collection'));

    $response = $this->actingAs($admin)->put(route('admin.events.update', $event), [
        'name' => 'New Name',
        'collection' => null,
    ]);

    tap(Event::withNotPublished()->first(), function ($updatedEvent) use ($response) {
        $this->assertEquals('New Name', $updatedEvent->name);
        $this->assertNull($updatedEvent->extras?->get('collection'));
        $response->assertRedirect();
    });

});
