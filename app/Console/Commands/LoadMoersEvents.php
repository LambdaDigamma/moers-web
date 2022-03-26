<?php

namespace App\Console\Commands;

use App\Models\Event;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
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

    protected $unids;
    protected $currentUnid;

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
        $client = new Client();
        $request = new Request('GET', 'https://www.moers.de/www/event.nsf/apijson.xsp/view-event-month');

        $promise = $client->sendAsync($request)->then(function ($response) {
            $data = $response->getBody();
            $json = collect(json_decode($data, true));

            $this->unids = $json->map(function ($item, $key) {
                return $item['@unid'];
            });

            $this->info('Successfully recognized ' . $this->unids->count() . ' events this month.');

            $this->getNextEvent();
        });

        $promise->wait();
    }

    public function getNextEvent()
    {
        $unid = $this->unids->shift();

        if ($unid !== null) {
            $client = new Client();
            $request = new Request('GET', 'https://www.moers.de/www/event.nsf/apijson.xsp/doc/' . $unid);

            $this->currentUnid = $unid;

            $promise = $client->sendAsync($request)->then(function ($response) {
                $data = collect(json_decode($response->getBody(), true));

                $title = $data->get('EventTitle');
                $start = $data->get('StartDateTime');
                $end = $data->get('EndDateTime');
                $docName = $data->get('DocNameWeb');
                $description = $data->get('Content_1');
                $eventType = $data->get('EventType');
                $location = $data->get('LocationName');
                $street = $data->get('LocationStreetAddress');
                $postcode = $data->get('LocationZIP');
                $city = $data->get('LocationCity');
                $organizer = $data->get('VeranstalterName');

                $finalStart = null;
                $finalEnd = null;
                $url = null;
                $category = null;

                // Start

                if (is_array($start) or ($start instanceof Traversable)) {
                    $finalStart = $this->cleanTimeString($start[0]);
                } elseif ($start !== null) {
                    $finalStart = $this->cleanTimeString($start);
                }

                // End

                if (is_array($end) or ($end instanceof Traversable)) {
                    $finalEnd = $this->cleanTimeString(end($end));
                } elseif ($end !== null) {
                    $finalEnd = $this->cleanTimeString($end);
                } else {
                    $endDate = Carbon::parse($data->get('StartDate'), 'Europe/Berlin');

                    $endDate->setTimezone('Europe/Berlin');
                    $endTime = $data->get('EndTime');

                    if ($endDate !== null && $endDate !== false && $endTime !== null) {
                        $finalEnd = $endDate->format('Y-m-d') . ' ' . $endTime;
                    }
                }

                // URL

                if ($docName !== null) {
                    $url = 'https://www.moers.de/de/veranstaltungen/' . $docName;
                }

                // Category

                if (is_array($eventType) or ($eventType instanceof Traversable)) {
                    $category = implode(', ', $eventType);
                } else {
                    $category = $eventType;
                }

                $newEvent = Event::firstOrCreate(['extras->unid' => $this->currentUnid], ['name' => '']);

                $newEvent->name = $title;
                $newEvent->start_date = $finalStart;
                $newEvent->end_date = $finalEnd != null ? Carbon::parse($finalEnd, 'Europe/Berlin')->setTimezone('UTC') : null;
                $newEvent->url = $url;
                $newEvent->description = trim($description);
                $newEvent->category = $category;
                $newEvent->published_at = now();

                $attendanceMode = Event::ATTENDANCE_OFFLINE;
                
                if ($location == 'online-Veranstaltung') {
                    $attendanceMode = Event::ATTENDANCE_ONLINE;
                }

                $newEvent->extras = collect([
                    'unid' => $this->currentUnid,
                    'location' => $location,
                    'street' => $street,
                    'postcode' => $postcode,
                    'place' => $city,
                    'organizer' => $organizer,
                    'attendance_mode' => $attendanceMode,
                ]);

                $newEvent->save();

                $this->info('Successfully loaded event \'' . $newEvent->name .'\'.');

                $this->currentUnid = null;
                $this->getNextEvent();
            });

            $promise->wait();
        }
    }

    protected function cleanTime($time)
    {
        if ($time !== null) {
            if (!(strpos($time, 'T') !== false)) {
                $time .= 'T00:00:00Z';
            }

            return $time;
        } else {
            return null;
        }
    }

    protected function cleanTimeString($timeString)
    {
        $cleanedTimeString = $this->cleanTime($timeString);

        try {
            $date = new Carbon($cleanedTimeString, 'Europe/Berlin');

            return $date->setTimezone('UTC')->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            $this->error($e->getMessage());

            return null;
        }
    }
}
