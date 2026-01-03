<?php

namespace Modules\Events\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Events\Models\Event;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Swis\JsonApi\Client\Item;

class LoadMoersEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly string $href
    ) {}

    public function handle(): int
    {
        $data = $this->fetchEventData();

        if (! $data) {
            return 0;
        }

        $event = $this->updateOrCreateEvent($data);

        $this->fetchTeaserImage($data, $event);

        $venueData = $this->fetchVenueData($data);

        $this->updateEventExtras($event, $data, $venueData);

        // Explicitly free memory
        unset($data, $venueData);

        return 0;
    }

    /**
     * Fetch event data from API.
     */
    private function fetchEventData(): ?Item
    {
        return Http::asJsonApi()
            ->get($this->href)
            ->jsonApi()
            ->getData();
    }

    /**
     * Update or create the event.
     */
    private function updateOrCreateEvent(Item $data): Event
    {
        return Event::updateOrCreate(
            ['extras->unid' => $data->id],
            [
                'name'         => $data->title,
                'description'  => $data->field_nsf_teaser_text,
                'start_date'   => $this->parseDate($data->field_evt_date?->value),
                'end_date'     => $this->parseDate($data->field_evt_date?->end_value),
                'url'          => 'https://moers.de' . $data->path->alias,
                'published_at' => now(),
                'created_at'   => $this->parseDate($data->created),
                'updated_at'   => $this->parseDate($data->changed),
            ]
        );
    }

    /**
     * Fetch venue data if available.
     */
    private function fetchVenueData(Item $data): ?Item
    {
        $venueHref = $data
            ->field_evt_media_venue_ref
            ?->getLinks()
            ?->related
            ?->getHref();

        if (! $venueHref) {
            return null;
        }

        return Http::asJsonApi()
            ->get($venueHref)
            ->jsonApi()
            ->getData();
    }

    /**
     * Fetch and attach teaser image.
     */
    private function fetchTeaserImage(Item $data, Event $event): void
    {
        $teaserHref = $data
            ->getRelationships()['field_nsf_teaser_image_ref']['links']['related']['href']
            ?? null;

        if (! $teaserHref) {
            return;
        }

        $teaserItem = Http::asJsonApi()
            ->get($teaserHref)
            ->jsonApi()
            ->getData();

        if (! $teaserItem) {
            return;
        }

        $meta = $teaserItem->field_media_image?->getMeta();
        $altText = $meta['alt'] ?? null;

        $mediaHref = $teaserItem
            ->getRelationships()['field_media_image']['links']['related']['href']
            ?? null;

        unset($teaserItem, $meta);

        if (! $mediaHref) {
            return;
        }

        $mediaData = Http::asJsonApi()
            ->get($mediaHref)
            ->jsonApi()
            ->getData();

        $url = isset($mediaData->uri->url)
            ? 'https://moers.de' . $mediaData->uri->url
            : null;

        unset($mediaData);

        if (! $url) {
            return;
        }

        try {
            $event->clearMediaCollection(Event::HEADER_MEDIA_COLLECTION);

            $event
                ->addMediaFromUrl($url)
                ->withCustomProperties(['alt' => $altText])
                ->toMediaCollection(Event::HEADER_MEDIA_COLLECTION);
        } catch (FileDoesNotExist | FileIsTooBig | FileCannotBeAdded $e) {
            Log::warning('Failed to attach teaser image', [
                'event_id' => $event->id,
                'url'      => $url,
                'error'    => $e->getMessage(),
            ]);
        }
    }

    /**
     * Update event extras.
     */
    private function updateEventExtras(Event $event, Item $data, ?Item $venueData): void
    {
        $extras = [
            'unid'            => $data->id,
            'attendance_mode' => Event::ATTENDANCE_OFFLINE,
            'location'        => $data->field_venue_alt,
        ];

        if ($venueData?->field_add_address) {
            $address = $venueData->field_add_address;

            $extras['location'] = $venueData->name;
            $extras['street']   = trim(
                "{$address->street} {$address->house_number}{$address->houseNumberAddition}"
            );
            $extras['postcode'] = $address->zip;
            $extras['place']    = $address->city;
        }

        $event->update(['extras' => $extras]);
    }

    /**
     * Parse a date string to UTC Carbon instance.
     */
    private function parseDate(?string $date): ?Carbon
    {
        return $date
            ? Carbon::parse($date)->utc()
            : null;
    }
}
