<?php

namespace Modules\Events\Jobs;

use DOMDocument;
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

        $pageData = $event->url ? $this->fetchEventPageData($event->url, $event->name) : [];
        $venueData = $this->fetchVenueData($data);

        $this->updateEventContent($event, $data, $pageData);
        $this->updateEventExtras($event, $data, $venueData, $pageData);

        // Explicitly free memory
        unset($data, $pageData, $venueData);

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
                'name' => $data->title,
                'description' => $data->field_nsf_teaser_text,
                'start_date' => $this->parseDate($data->field_evt_date?->value),
                'end_date' => $this->parseDate($data->field_evt_date?->end_value),
                'url' => 'https://moers.de'.$data->path->alias,
                'published_at' => now(),
                'created_at' => $this->parseDate($data->created),
                'updated_at' => $this->parseDate($data->changed),
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

    private function fetchEventPageData(string $url, string $title): array
    {
        try {
            $response = Http::get($url);
        } catch (\Throwable $throwable) {
            Log::warning('Failed to fetch moers event detail page', [
                'url' => $url,
                'error' => $throwable->getMessage(),
            ]);

            return [];
        }

        if (! $response->successful()) {
            Log::warning('Moers event detail page returned unexpected status', [
                'url' => $url,
                'status' => $response->status(),
            ]);

            return [];
        }

        return $this->parseEventPageHtml($response->body(), $title);
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
            ? 'https://moers.de'.$mediaData->uri->url
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
        } catch (FileDoesNotExist|FileIsTooBig|FileCannotBeAdded $e) {
            Log::warning('Failed to attach teaser image', [
                'event_id' => $event->id,
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function parseEventPageHtml(string $html, string $title): array
    {
        $lines = $this->extractVisibleLinesFromHtml($html);

        if ($lines === []) {
            return [];
        }

        return $this->parseEventPageLines($lines, $title);
    }

    public function extractVisibleLinesFromHtml(string $html): array
    {
        $internalErrors = libxml_use_internal_errors(true);
        $document = new DOMDocument;
        $document->loadHTML('<?xml encoding="utf-8" ?>'.$html, LIBXML_NOERROR | LIBXML_NOWARNING);

        foreach (['script', 'style', 'noscript', 'svg'] as $tagName) {
            while (($nodes = $document->getElementsByTagName($tagName))->length > 0) {
                $nodes->item(0)?->parentNode?->removeChild($nodes->item(0));
            }
        }

        $textContent = html_entity_decode($document->textContent ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');

        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);

        return collect(preg_split('/\R/u', $textContent) ?: [])
            ->map(fn (string $line) => preg_replace('/\s+/u', ' ', trim($line)) ?? '')
            ->filter()
            ->values()
            ->all();
    }

    public function parseEventPageLines(array $lines, string $title): array
    {
        $titleIndex = collect($lines)->search(fn (string $line) => $line === $title);

        if ($titleIndex === false) {
            return [];
        }

        $detailsIndex = collect($lines)->search(fn (string $line) => $line === 'Event details');

        $contentLines = array_slice(
            $lines,
            $titleIndex + 1,
            $detailsIndex === false ? null : $detailsIndex - $titleIndex - 1,
        );

        $detailsLines = $detailsIndex === false ? [] : array_slice($lines, $detailsIndex + 1);
        $detailMap = $this->parseEventDetails($detailsLines);
        $locationData = $this->parseLocationLines($detailMap['Veranstaltungsort'] ?? []);
        $organizerAddress = $this->parseAddressLines($detailMap['Adresse'] ?? []);

        return [
            'subtitle' => $contentLines[0] ?? null,
            'description' => $contentLines === [] ? null : implode("\n\n", $contentLines),
            'location' => $locationData['location'],
            'street' => $locationData['street'],
            'postcode' => $locationData['postcode'],
            'place' => $locationData['place'],
            'organizer' => $this->joinDetailLines($detailMap['Firma'] ?? []),
            'organizer_street' => $organizerAddress['street'],
            'organizer_postcode' => $organizerAddress['postcode'],
            'organizer_place' => $organizerAddress['place'],
            'organizer_phone' => $this->joinDetailLines($detailMap['Telefon'] ?? []),
            'organizer_email' => $this->joinDetailLines($detailMap['E-Mail'] ?? []),
            'organizer_website' => $this->joinDetailLines($detailMap['Internetseite'] ?? []),
        ];
    }

    private function parseEventDetails(array $lines): array
    {
        $labels = ['Veranstaltungsdatum', 'Veranstaltungsort', 'Veranstalter', 'Firma', 'Adresse', 'Telefon', 'E-Mail', 'Internetseite'];
        $details = [];
        $currentLabel = null;

        foreach ($lines as $line) {
            if (in_array($line, ['Hauptnavigation', 'Suche', 'Service', 'Footer'], true)) {
                break;
            }

            if (in_array($line, $labels, true)) {
                $currentLabel = $line;
                $details[$currentLabel] ??= [];

                continue;
            }

            if ($currentLabel === null) {
                continue;
            }

            $details[$currentLabel][] = $line;
        }

        return $details;
    }

    private function parseLocationLines(array $lines): array
    {
        if ($lines === []) {
            return [
                'location' => null,
                'street' => null,
                'postcode' => null,
                'place' => null,
            ];
        }

        $street = $lines[0] ?? null;
        $postcode = null;
        $place = null;
        $location = count($lines) >= 3 ? $lines[count($lines) - 1] : null;

        if (isset($lines[1]) && preg_match('/^(?<postcode>\d{5})\s+(?<place>.+)$/u', $lines[1], $matches) === 1) {
            $postcode = $matches['postcode'];
            $place = $matches['place'];
        }

        return [
            'location' => $location,
            'street' => $street,
            'postcode' => $postcode,
            'place' => $place,
        ];
    }

    private function parseAddressLines(array $lines): array
    {
        $street = $lines[0] ?? null;
        $postcode = null;
        $place = null;

        if (isset($lines[1]) && preg_match('/^(?<postcode>\d{5})\s+(?<place>.+)$/u', $lines[1], $matches) === 1) {
            $postcode = $matches['postcode'];
            $place = $matches['place'];
        }

        return [
            'street' => $street,
            'postcode' => $postcode,
            'place' => $place,
        ];
    }

    private function joinDetailLines(array $lines): ?string
    {
        $value = implode("\n", array_filter($lines));

        return $value !== '' ? $value : null;
    }

    private function updateEventContent(Event $event, Item $data, array $pageData): void
    {
        $event->update([
            'description' => $pageData['description'] ?? $data->field_nsf_teaser_text,
        ]);
    }

    /**
     * Update event extras.
     */
    private function updateEventExtras(Event $event, Item $data, ?Item $venueData, array $pageData): void
    {
        $extras = [
            'unid' => $data->id,
            'attendance_mode' => Event::ATTENDANCE_OFFLINE,
            'location' => $data->field_venue_alt,
            'teaser' => $data->field_nsf_teaser_text,
            'subtitle' => $pageData['subtitle'] ?? null,
            'organizer' => $pageData['organizer'] ?? null,
            'organizer_street' => $pageData['organizer_street'] ?? null,
            'organizer_postcode' => $pageData['organizer_postcode'] ?? null,
            'organizer_place' => $pageData['organizer_place'] ?? null,
            'organizer_phone' => $pageData['organizer_phone'] ?? null,
            'organizer_email' => $pageData['organizer_email'] ?? null,
            'organizer_website' => $pageData['organizer_website'] ?? null,
        ];

        if ($venueData?->field_add_address) {
            $address = $venueData->field_add_address;

            $extras['location'] = $venueData->name;
            $extras['street'] = trim(
                "{$address->street} {$address->house_number}{$address->houseNumberAddition}"
            );
            $extras['postcode'] = $address->zip;
            $extras['place'] = $address->city;
        } else {
            $extras['location'] = $pageData['location'] ?? $extras['location'];
            $extras['street'] = $pageData['street'] ?? null;
            $extras['postcode'] = $pageData['postcode'] ?? null;
            $extras['place'] = $pageData['place'] ?? null;
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
