<?php

namespace Modules\Events\Jobs;

use GuzzleHttp\Client;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Log;
use Modules\Events\Models\Event;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Swis\JsonApi\Client\Item;
use Swis\JsonApi\Client\Meta;

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

    public function handle(): int
    {
        $data = $this->fetchEventData();
        $event = $this->updateOrCreateEvent($data);

        $this->fetchTeaserImage(data: $data, event: $event);
        $venueData = $this->fetchVenueData($data);

        $this->updateEventExtras(event: $event, data: $data, venueData: $venueData);



        return 0;
    }

    /**
     * Fetch event data from API.
     */
    private function fetchEventData(): Item
    {
        return Http::asJsonApi()->get($this->href)->jsonApi()->getData();
    }

    /**
     * Update or create the event.
     */
    private function updateOrCreateEvent(object $data): Event
    {
        return Event::updateOrCreate(
            ['extras->unid' => $data->id],
            [
                'name' => $data->title,
                'description' => $data->field_nsf_teaser_text,
                'start_date' => $this->parseDate($data->field_evt_date?->value),
                'end_date' => $this->parseDate($data->field_evt_date?->end_value),
                'url' => 'https://moers.de' . $data->path->alias,
                'published_at' => now(),
                'created_at' => $this->parseDate($data->created),
                'updated_at' => $this->parseDate($data->changed),
            ]
        );
    }

    /**
     * Fetch venue data if available.
     */
    private function fetchVenueData(object $data): ?object
    {
        $venueLink = $data->field_evt_media_venue_ref?->getLinks()?->related?->getHref();
        $venueData = $venueLink ? Http::asJsonApi()->get($venueLink)->jsonApi()->getData() : null;

        return $venueData;
    }

    private function fetchTeaserImage(Item $data, Event $event): void
    {
        $teaserImageHref = $data->getRelationships()['field_nsf_teaser_image_ref']["links"]["related"]["href"];
        /** @var Item|null $teaserImageData */
        $teaserImageData = $teaserImageHref ? Http::asJsonApi()->get($teaserImageHref)->jsonApi()->getData() : null;

        if (! $teaserImageData) {
            return;
        }

        /** @var Meta $meta */
        $meta = $teaserImageData->field_media_image->getMeta();
        $altText = $meta['alt'];

        $mediaHref = $teaserImageData->getRelationships()['field_media_image']['links']['related']['href'];
        $mediaData = Http::asJsonApi()->get($mediaHref)->jsonApi()->getData();
        $url = "https://moers.de{$mediaData->uri->url}";

        try {
            $event->clearMediaCollection(Event::HEADER_MEDIA_COLLECTION);

            $event
                ->addMediaFromUrl($url)
                ->withCustomProperties(['alt' => $altText])
                ->toMediaCollection(Event::HEADER_MEDIA_COLLECTION);
        } catch (FileDoesNotExist|FileIsTooBig|FileCannotBeAdded $e) {
            Log::error('Could not add media to event', ['event' => $event->id, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Update event extras.
     */
    private function updateEventExtras(Event $event, object $data, ?object $venueData): void
    {
        $extras = collect([
            'unid' => $data->id,
            'attendance_mode' => Event::ATTENDANCE_OFFLINE,
            'location' => $data->field_venue_alt,
        ]);

        if ($venueData?->field_add_address) {
            $address = $venueData->field_add_address;
            $extras->put('location', $venueData->name);
            $extras->put('street', trim("{$address->street} {$address->house_number}{$address->houseNumberAddition}"));
            $extras->put('postcode', $address->zip);
            $extras->put('place', $address->city);
        }

        $event->update(['extras' => $extras->toArray()]);
    }

    /**
     * Parse a date string to Carbon instance.
     */
    private function parseDate(?string $date): ?Carbon
    {
        return $date ? Carbon::parse($date)->timezone('UTC') : null;
    }

}
