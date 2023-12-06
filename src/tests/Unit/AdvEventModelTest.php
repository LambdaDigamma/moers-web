<?php

namespace Tests\Unit;

use App\Models\AdvEvent;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvEventModelTest extends TestCase
{
    
    public function testScopeActive()
    {

        $activeEventStartEnd = AdvEvent::factory()
            ->activeStartEnd()
            ->create()
            ->first();

        $activeEventInDeadline = AdvEvent::factory()
            ->activeStart()
            ->create()
            ->first();

        $upcomingStartEvents = AdvEvent::factory(5)
            ->upcomingStart()
            ->create();

        $activeEventsDatabase = AdvEvent::active()->pluck('id');

        $this->assertTrue($activeEventsDatabase->contains($activeEventStartEnd->id));
        $this->assertTrue($activeEventsDatabase->contains($activeEventInDeadline->id));
        $this->assertFalse($activeEventsDatabase->contains($upcomingStartEvents->first()->id));

    }

    public function testScopePublished()
    {

        $publishedEvents = AdvEvent::factory(3)
            ->published()
            ->create();

        $notPublishedEvents = AdvEvent::factory(3)
            ->notPublished()
            ->create();

        $events = AdvEvent::published()->pluck('id');

        $this->assertTrue($events->contains($publishedEvents->first()->id));
        $this->assertFalse($events->contains($notPublishedEvents->first()->id));

    }

}
