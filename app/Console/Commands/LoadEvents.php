<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Orchestra\Parser\Xml\Facade as XmlParser;

class LoadEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loads all events from offenesdatenportal.de.';

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
     * @return mixed
     */
    public function handle()
    {

        $xml = XmlParser::load("https://www.moers.de/de/opendataxml/veranstaltungen/");

        $events = $xml->parse([
            'events' => ['uses' => 'entry[title,date,time,documenturl,locationname,location,locationstreetaddress,locationzip,organizername,organizercity,organizerstreetaddress,organizerzip,organizerurl]'],
        ])["events"];

        $e = collect($events)->recursive();

        $e->each(function ($item, $key) {

            $item->put('url', $item->get('documenturl'));
            $item->put('name', $item->get('title'));

            $item->forget('organizerurl');
            $item->forget('organizerzip');
            $item->forget('organizerstreetaddress');
            $item->forget('organizercity');
            $item->forget('organizername');
            $item->forget('documenturl');
            $item->forget('title');
            $item->forget('locationname');
            $item->forget('location');
            $item->forget('locationstreetaddress');
            $item->forget('locationzip');

            $date = str_replace(' 00:00:00', '', $item->get('date'));
            $date = explode(' ', $date)[0];

            $item->put('date', $date);
            $item->put('description', '');
            $item->put('time_start', $item->get('time'));

            if ($item->get('time_start') == null) {
                $item->put('time_start', '');
            }

            $item->forget('time');

        });

        $e->each(function ($item, $key) {

            $event = Event::create($item->all());

        });

        $this->info('Successfully loaded new events.');
    }

}
