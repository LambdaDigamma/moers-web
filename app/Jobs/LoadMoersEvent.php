<?php

namespace App\Jobs;

use App\Models\Event;
use GuzzleHttp\Client;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class LoadMoersEvent
{
    use Dispatchable;

    protected Client $client;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public string $href)
    {
        $this->client = new Client();
    }

    public function handle()
    {
        $document = Http::asJsonApi()
            ->get($this->href)
            ->jsonApi();

        $data = $document->getData();

        $uuid = $data->id;
        $title = $data->title;
        $description = $data->field_nsf_teaser_text;
        $start_date = $data->field_evt_date?->value ? Carbon::parse($data->field_evt_date->value)->timezone('UTC') : null;
        $end_date = $data->field_evt_date?->end_value ? Carbon::parse($data->field_evt_date->end_value)->timezone('UTC') : null;
        $url = 'https://moers.de' . $data->path->alias;
        $created_at = Carbon::parse($data->created)->timezone('UTC');
        $updated_at = Carbon::parse($data->changed)->timezone('UTC');
        $data_url = $data->getLinks()->self->getHref();

        $newEvent = Event::firstWhere('extras->unid', $uuid);

        if (! $newEvent) {
            $newEvent = Event::create([
                'name' => $title,
                'extras->unid' => $uuid,
            ]);
        }

        $newEvent->name = $title;
        $newEvent->description = $description;
        $newEvent->start_date = $start_date;
        $newEvent->end_date = $end_date;
        $newEvent->url = $url;
        $newEvent->published_at = now();
        $newEvent->created_at = $created_at;
        $newEvent->updated_at = $updated_at;

        $attendanceMode = Event::ATTENDANCE_OFFLINE;

        $extras = collect([
            'unid' => $uuid,
            'attendance_mode' => $attendanceMode,
        ]);



        $venueLink = $document->getData()->field_evt_media_venue_ref()?->getLinks()?->related?->getHref();

        if ($venueLink) {
            $venueData = Http::asJsonApi()
                ->get($venueLink)
                ->jsonApi()
                ->getData();

            $address = $venueData?->field_add_address;

            $extras->put('location', $data->field_venue_alt);

            if ($address) {
                $extras->put('location', $venueData->name);
                $extras->put('street', str($address->street . ' ' . ($address->house_number ?? '') . ($address->houseNumberAddition ?? ''))->trim()->toString());
                $extras->put('postcode', $address->zip);
                $extras->put('place', $address->city);
            }

            $newEvent->extras = $extras->toArray();
        }

        $newEvent->save();

    }
}
