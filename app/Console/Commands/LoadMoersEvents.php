<?php

namespace App\Console\Commands;

use App\Models\Event;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Swis\JsonApi\Client\Facades\DocumentFactoryFacade;
use Swis\JsonApi\Client\Interfaces\DocumentInterface;
use Swis\JsonApi\Client\Item;
use Traversable;

class LoadMoersEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:load-moers-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load all events for the next month from moers backend.';

    protected $client;
    protected $hrefs;
    protected $currentHref;

    protected array $events = [];
    protected array $urls = [];
    protected array $eventUrls = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->client = new Client();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $document = Http::asJsonApi()
            ->get('https://www.moers.de/jsonapi/node/event')
            ->jsonApi();

        $this->handleDocument($document);

        while ($document->getLinks()->next) {
            $this->urls[] = $document->getLinks()->next->getHref();
            $document = Http::asJsonApi()
                ->get($document->getLinks()->next->getHref())
                ->jsonApi();
            $this->handleDocument($document);
        }

        $this->info('Found ' . count($this->eventUrls) . ' events.');

        foreach ($this->events as $event) {
            $this->info('Loading event ' . $event['title']);

//                $eventType = $data->get('EventType');
//                $location = $data->get('LocationName');
//                $street = $data->get('LocationStreetAddress');
//                $postcode = $data->get('LocationZIP');
//                $city = $data->get('LocationCity');
//                $organizer = $data->get('VeranstalterName');
//
//                // Category
//
//                if (is_array($eventType) or ($eventType instanceof Traversable)) {
//                    $category = implode(', ', $eventType);
//                } else {
//                    $category = $eventType;
//                }
//
            $newEvent = Event::firstWhere('extras->unid', $event['uuid']);

            if (! $newEvent) {
                $newEvent = Event::create([
                    'name' => $event['title'],
                    'extras->unid' => $event['uuid']
                ]);
            }

            $newEvent->name = $event['title'];
            $newEvent->description = $event['description'];
            $newEvent->start_date = $event['start_date'];
            $newEvent->end_date = $event['end_date'] ?? null;
            $newEvent->url = $event['url'];
            $newEvent->published_at = now();
            $newEvent->created_at = $event['created_at'];
            $newEvent->updated_at = $event['updated_at'];
            $extras = [];
            $extras['unid'] = $event['uuid'];

            $newEvent->extras = $extras;
            $newEvent->save();


//                $newEvent->category = $category;
//
//                $attendanceMode = Event::ATTENDANCE_OFFLINE;
//
//                if ($location == 'online-Veranstaltung') {
//                    $attendanceMode = Event::ATTENDANCE_ONLINE;
//                }
//
//                $newEvent->extras = collect([
//                    'unid' => $this->currentUnid,
//                    'location' => $location,
//                    'street' => $street,
//                    'postcode' => $postcode,
//                    'place' => $city,
//                    'organizer' => $organizer,
//                    'attendance_mode' => $attendanceMode,
//                ]);
        }

        return 0;
    }

    public function handleDocument(DocumentInterface $document)
    {
        $events = $document->getData();

        foreach ($events as $event) {
            $data = [
                'uuid' => $event->id,
                'title' => $event->title,
                'description' => $event->field_nsf_teaser_text,
                'start_date' => $event->field_evt_date?->value ? Carbon::parse($event->field_evt_date->value)->timezone('UTC') : null,
                'end_date' => $event->field_evt_date?->end_value ? Carbon::parse($event->field_evt_date->end_value)->timezone('UTC') : null,
                'url' => 'https://moers.de' . $event->path->alias,
                'created_at' => Carbon::parse($event->created),
                'updated_at' => Carbon::parse($event->changed),
                'data_url' => $event->getLinks()->self->getHref(),
            ];

            $this->events[] = $data;
            $this->eventUrls[] = $event->getLinks()->self->getHref();
        }
    }


    public function updateOrCreateNextEvent()
    {
        $href = $this->hrefs->shift();
        $request = new Request('GET', $href);
        $this->currentHref = $href;

        $promise = $this->client->sendAsync($request)->then(function ($response) {
            $data = collect(json_decode($response->getBody(), true)['data']);

            $title = $data->get('attributes')['title'];

            dd($title);


            $this->currentHref = null;
        });

        $promise->wait();
    }

//                $eventType = $data->get('EventType');
//                $location = $data->get('LocationName');
//                $street = $data->get('LocationStreetAddress');
//                $postcode = $data->get('LocationZIP');
//                $city = $data->get('LocationCity');
//                $organizer = $data->get('VeranstalterName');

//                // Category
//
//                if (is_array($eventType) or ($eventType instanceof Traversable)) {
//                    $category = implode(', ', $eventType);
//                } else {
//                    $category = $eventType;
//                }
//
//                $newEvent->category = $category;
//
//                $attendanceMode = Event::ATTENDANCE_OFFLINE;
//
//                if ($location == 'online-Veranstaltung') {
//                    $attendanceMode = Event::ATTENDANCE_ONLINE;
//                }
//
//                $newEvent->extras = collect([
//                    'unid' => $this->currentUnid,
//                    'location' => $location,
//                    'street' => $street,
//                    'postcode' => $postcode,
//                    'place' => $city,
//                    'organizer' => $organizer,
//                    'attendance_mode' => $attendanceMode,
//                ]);
//
//                $newEvent->save();
//
//                $this->info('Successfully loaded event \'' . $newEvent->name .'\'.');
//
//                $this->currentUnid = null;
//                $this->getNextEvent();
//            });
//
//            $promise->wait();
//        }
//    }
//
//    protected function cleanTime($time)
//    {
//        if ($time !== null) {
//            if (!(strpos($time, 'T') !== false)) {
//                $time .= 'T00:00:00Z';
//            }
//
//            return $time;
//        } else {
//            return null;
//        }
//    }
//
//    protected function cleanTimeString($timeString)
//    {
//        $cleanedTimeString = $this->cleanTime($timeString);
//
//        try {
//            $date = new Carbon($cleanedTimeString, 'Europe/Berlin');
//
//            return $date->setTimezone('UTC')->format('Y-m-d H:i:s');
//        } catch (Exception $e) {
//            $this->error($e->getMessage());
//
//            return null;
//        }
//    }
}
