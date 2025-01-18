<?php

namespace Modules\Multimedia\Console\Commands;

use ICal\ICal;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Modules\Multimedia\Models\RadioBroadcast;

class LoadRadio extends Command
{
    protected $signature = 'radio-broadcasts:load';

    protected $description = 'Loads radio broadcasts';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        try {
            $this->info('Loading radio broadcasts...');

            $nextYear = Carbon::now()->addYear()->year;
            $cal = new ICal("http://www.buergerfunk-moers.de/events/?ical=1&tribe_display=custom&end_date={$nextYear}", [
                'defaultTimeZone' => 'UTC',
            ]);

            $this->info('Found ' . count($cal->events()) . ' upcoming or previous broadcasts.');

            $broadcasts = collect($cal->events())->map(function ($event) {
                return RadioBroadcast::updateOrCreate([
                    'uid' => $event->uid,
                ], [
                    'title' => $event->summary,
                    'description' => $event->description,
                    'url' => $event->url,
                    'attach' => $event->attach ?? null,
                    'starts_at' => Carbon::parse($event->dtstart, 'Europe/Berlin')->setTimezone('UTC'),
                    'ends_at' => Carbon::parse($event->dtend, 'Europe/Berlin')->setTimezone('UTC'),
                ]);
            });

            $this->info('Created or updated broadcasts.');

            $this->table(['Name', 'Start (UTC)', 'End (UTC)'], $broadcasts->map(function ($broadcast) {
                return [
                    $broadcast->title,
                    $broadcast->starts_at,
                    $broadcast->ends_at
                ];
            }));

        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        return 0;
    }
}
