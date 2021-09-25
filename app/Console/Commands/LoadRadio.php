<?php

namespace App\Console\Commands;

use App\Models\RadioBroadcast;
use ICal\ICal;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class LoadRadio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'radio-broadcasts:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loads radio broadcasts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->info('Loading radio broadcasts...');

            $cal = new ICal('http://www.buergerfunk-moers.de/events/?ical=1&tribe_display=list', [
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
