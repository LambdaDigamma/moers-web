<?php

namespace Tests\Unit;

use App\Models\AdvEvent;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvEventModelTest extends TestCase
{

    use DatabaseMigrations;
    use RefreshDatabase;

    public function testScopeActive()
    {

        $activeEventStartEnd = factory(AdvEvent::class, 1)
            ->states('active_start_end')
            ->create()
            ->first();

        $activeEventInDeadline = factory(AdvEvent::class, 1)
            ->states('active_start')
            ->create()
            ->first();

        $upcomingStartEvents = factory(AdvEvent::class, 5)
            ->states('upcoming_start')
            ->create();

        $activeEventsDatabase = AdvEvent::active()->pluck('id');

        $this->assertTrue($activeEventsDatabase->contains($activeEventStartEnd->id));
        $this->assertTrue($activeEventsDatabase->contains($activeEventInDeadline->id));
        $this->assertFalse($activeEventsDatabase->contains($upcomingStartEvents->first()->id));

    }

    public function testScopePublished()
    {

        $publishedEvents = factory(AdvEvent::class, 3)
            ->state('published')
            ->create();

        $notPublishedEvents = factory(AdvEvent::class, 3)
            ->state('not_published')
            ->create();

        $events = AdvEvent::published()->pluck('id');

        $this->assertTrue($events->contains($publishedEvents->first()->id));
        $this->assertFalse($events->contains($notPublishedEvents->first()->id));

    }

}
