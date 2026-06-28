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
use Illuminate\Support\Str;
use Modules\Events\Models\Event;
use Modules\Management\Actions\ResolveImportedOrganisation;
use Modules\Management\Models\Organisation;
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

        $venueData = $this->fetchVenueData($data);
        $organizerData = $this->fetchOrganizerData($data);
        $contentItems = $this->fetchRelatedItems($data, 'field_nsf_content_ref');
        $contentDescription = $this->extractContentDescription($contentItems);
        $category = $this->fetchCategory($data);
        $organisation = $this->resolveOrganisation($organizerData);

        $event = $this->updateOrCreateEvent($data, $organisation);
        $this->fetchHeaderImage($data, $event, $contentItems);

        $pageData = $event->url ? $this->fetchEventPageData($event->url, $event->name) : [];

        $this->updateEventContent($event, $data, $pageData, $contentDescription, $category);
        $this->updateEventExtras($event, $data, $venueData, $organizerData, $pageData);

        // Explicitly free memory
        unset($data, $pageData, $venueData, $organizerData, $contentItems, $contentDescription, $category, $organisation);

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
    private function updateOrCreateEvent(Item $data, ?Organisation $organisation): Event
    {
        $attributes = [
            'name' => $data->title,
            'description' => $data->field_nsf_teaser_text,
            'start_date' => $this->parseDate($data->field_evt_date?->value),
            'end_date' => $this->parseDate($data->field_evt_date?->end_value),
            'url' => 'https://moers.de'.$data->path->alias,
            'published_at' => now(),
            'created_at' => $this->parseDate($data->created),
            'updated_at' => $this->parseDate($data->changed),
        ];

        if ($organisation) {
            $attributes['organisation_id'] = $organisation->id;
        }

        return Event::updateOrCreate(
            ['extras->unid' => $data->id],
            $attributes,
        );
    }

    /**
     * Fetch venue data if available.
     */
    private function fetchVenueData(Item $data): ?Item
    {
        return $this->fetchRelatedItem($data, 'field_evt_media_venue_ref');
    }

    private function fetchOrganizerData(Item $data): ?Item
    {
        return $this->fetchRelatedItem($data, 'field_evt_media_organizer_ref');
    }

    private function resolveOrganisation(?Item $organizerData): ?Organisation
    {
        if (! $organizerData) {
            return null;
        }

        $organizer = $this->extractOrganizerData($organizerData);

        if (! $organizer['organizer']) {
            return null;
        }

        return app(ResolveImportedOrganisation::class)->handle(
            name: $organizer['organizer'],
            externalSource: 'moers:media.company',
            externalId: $organizerData->id,
            externalUrl: data_get($organizerData->getLinks(), 'self')?->getHref(),
            email: $organizer['organizer_email'],
            phone: $organizer['organizer_phone'],
            websiteUrl: $organizer['organizer_website'],
            street: $organizer['organizer_street'],
            postcode: $organizer['organizer_postcode'],
            city: $organizer['organizer_place'],
        );
    }

    /**
     * @param  array<int, Item>  $contentItems
     */
    private function extractContentDescription(array $contentItems): ?string
    {
        $contentBlocks = [];

        foreach ($contentItems as $contentItem) {
            $html = data_get($contentItem->field_text, 'processed')
                ?? data_get($contentItem->field_text, 'value');

            if (! is_string($html) || trim($html) === '') {
                continue;
            }

            $lines = $this->extractVisibleLinesFromHtml($html);

            if ($lines !== []) {
                $contentBlocks[] = implode("\n\n", $lines);
            }
        }

        return $contentBlocks === [] ? null : implode("\n\n", $contentBlocks);
    }

    private function fetchCategory(Item $data): ?string
    {
        $typeItems = $this->fetchRelatedItems($data, 'field_evt_type_ref');

        $categories = collect($typeItems)
            ->map(fn (Item $typeItem) => $this->normalizeFilledString($typeItem->name))
            ->filter()
            ->values();

        return $categories->isEmpty() ? null : $categories->implode(', ');
    }

    private function fetchRelatedItem(Item $data, string $relationship): ?Item
    {
        return $this->fetchRelatedItems($data, $relationship)[0] ?? null;
    }

    /**
     * @return array<int, Item>
     */
    private function fetchRelatedItems(Item $data, string $relationship): array
    {
        $relatedHref = $data->getRelationships()[$relationship]['links']['related']['href'] ?? null;

        if (! $relatedHref) {
            return [];
        }

        try {
            $response = Http::asJsonApi()->get($relatedHref);
        } catch (\Throwable $throwable) {
            Log::warning('Failed to fetch moers event related resource', [
                'relationship' => $relationship,
                'url' => $relatedHref,
                'error' => $throwable->getMessage(),
            ]);

            return [];
        }

        if (! $response->successful()) {
            Log::warning('Moers event related resource returned unexpected status', [
                'relationship' => $relationship,
                'url' => $relatedHref,
                'status' => $response->status(),
            ]);

            return [];
        }

        $relatedData = $response->jsonApi()->getData();

        if ($relatedData instanceof Item) {
            return [$relatedData];
        }

        if (is_iterable($relatedData)) {
            return collect($relatedData)
                ->filter(fn (mixed $item) => $item instanceof Item)
                ->values()
                ->all();
        }

        return [];
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
     * @param  array<int, Item>  $contentItems
     */
    private function fetchHeaderImage(Item $data, Event $event, array $contentItems): void
    {
        $imageData = $this->resolveTeaserImageData($data)
            ?? $this->resolveContentImageData($contentItems);

        if ($imageData === null) {
            return;
        }

        $this->replaceHeaderImage($event, $imageData['url'], $imageData['alt']);
    }

    /**
     * @return array{url: string, alt: ?string}|null
     */
    private function resolveTeaserImageData(Item $data): ?array
    {
        return $this->resolveImageDataFromMediaItem(
            $this->fetchRelatedItem($data, 'field_nsf_teaser_image_ref'),
        );
    }

    /**
     * @param  array<int, Item>  $contentItems
     * @return array{url: string, alt: ?string}|null
     */
    private function resolveContentImageData(array $contentItems): ?array
    {
        foreach ($contentItems as $contentItem) {
            $imageData = $this->resolveImageDataFromMediaItem(
                $this->fetchRelatedItem($contentItem, 'field_media_ref'),
            );

            if ($imageData !== null) {
                return $imageData;
            }
        }

        return null;
    }

    /**
     * @return array{url: string, alt: ?string}|null
     */
    private function resolveImageDataFromMediaItem(?Item $mediaItem): ?array
    {
        if (! $mediaItem) {
            return null;
        }

        foreach (['field_media_image', 'thumbnail'] as $relationship) {
            $meta = $mediaItem->{$relationship}?->getMeta();
            $fileItem = $this->fetchRelatedItem($mediaItem, $relationship);

            if (! isset($fileItem?->uri->url)) {
                continue;
            }

            return [
                'url' => 'https://moers.de'.$fileItem->uri->url,
                'alt' => $meta['alt'] ?? null,
            ];
        }

        return null;
    }

    private function replaceHeaderImage(Event $event, string $url, ?string $altText): void
    {
        try {
            $existingMedia = $event->getMedia(Event::HEADER_MEDIA_COLLECTION);

            $event
                ->addMediaFromUrl($url)
                ->withCustomProperties(['alt' => $altText])
                ->toMediaCollection(Event::HEADER_MEDIA_COLLECTION);

            $existingMedia->each->delete();
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
        } elseif (isset($lines[0]) && $address = $this->parseCondensedAddressLine($lines[0])) {
            $street = $address['street'];
            $postcode = $address['postcode'];
            $place = $address['place'];
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
        } elseif (isset($lines[0]) && $address = $this->parseCondensedAddressLine($lines[0])) {
            $street = $address['street'];
            $postcode = $address['postcode'];
            $place = $address['place'];
        }

        return [
            'street' => $street,
            'postcode' => $postcode,
            'place' => $place,
        ];
    }

    /**
     * @return array{street: string, postcode: string, place: string}|null
     */
    private function parseCondensedAddressLine(string $line): ?array
    {
        if (preg_match('/^(?<street>.+)(?<postcode>\d{5})\s*(?<place>.+)$/u', trim($line), $matches) !== 1) {
            return null;
        }

        return [
            'street' => trim($matches['street']),
            'postcode' => $matches['postcode'],
            'place' => trim($matches['place']),
        ];
    }

    private function joinDetailLines(array $lines): ?string
    {
        $value = implode("\n", array_filter($lines));

        return $value !== '' ? $value : null;
    }

    private function updateEventContent(Event $event, Item $data, array $pageData, ?string $contentDescription, ?string $category): void
    {
        $attributes = [
            'description' => $this->cleanDescription(
                $contentDescription ?? $pageData['description'] ?? $data->field_nsf_teaser_text,
                $event->name,
            ),
        ];

        if ($category !== null) {
            $attributes['category'] = $category;
        }

        $event->update($attributes);
    }

    /**
     * Update event extras.
     */
    private function updateEventExtras(Event $event, Item $data, ?Item $venueData, ?Item $organizerData, array $pageData): void
    {
        $venue = $this->extractVenueData($data, $venueData);
        $organizer = $this->extractOrganizerData($organizerData);

        $extras = array_merge($event->extras?->all() ?? [], array_filter([
            'unid' => $data->id,
            'attendance_mode' => Event::ATTENDANCE_OFFLINE,
            'location' => $venue['location'] ?? $pageData['location'] ?? $this->normalizeFilledString($data->field_venue_alt),
            'street' => $venue['street'] ?? $pageData['street'] ?? null,
            'postcode' => $venue['postcode'] ?? $pageData['postcode'] ?? null,
            'place' => $venue['place'] ?? $pageData['place'] ?? null,
            'latitude' => $venue['latitude'],
            'longitude' => $venue['longitude'],
            'teaser' => $data->field_nsf_teaser_text,
            'subtitle' => $pageData['subtitle'] ?? null,
            'organizer' => $organizer['organizer'] ?? $pageData['organizer'] ?? null,
            'organizer_street' => $organizer['organizer_street'] ?? $pageData['organizer_street'] ?? null,
            'organizer_postcode' => $organizer['organizer_postcode'] ?? $pageData['organizer_postcode'] ?? null,
            'organizer_place' => $organizer['organizer_place'] ?? $pageData['organizer_place'] ?? null,
            'organizer_phone' => $organizer['organizer_phone'] ?? $pageData['organizer_phone'] ?? null,
            'organizer_email' => $organizer['organizer_email'] ?? $pageData['organizer_email'] ?? null,
            'organizer_website' => $organizer['organizer_website'] ?? $pageData['organizer_website'] ?? null,
        ], fn (mixed $value): bool => $value !== null));

        $event->update(['extras' => $extras]);
    }

    /**
     * @return array{location: ?string, street: ?string, postcode: ?string, place: ?string, latitude: ?float, longitude: ?float}
     */
    private function extractVenueData(Item $eventData, ?Item $venueData): array
    {
        $addressData = $this->resolveAddressData($venueData);
        $address = $this->extractAddress($addressData?->field_add_address);
        $coordinates = $this->extractCoordinates($addressData?->field_add_geo);

        return [
            'location' => $this->normalizeFilledString($eventData->field_venue_alt)
                ?? $this->normalizeFilledString($venueData?->field_com_company)
                ?? $this->normalizeFilledString($venueData?->name),
            'street' => $address['street'],
            'postcode' => $address['postcode'],
            'place' => $address['place'],
            'latitude' => $coordinates['latitude'],
            'longitude' => $coordinates['longitude'],
        ];
    }

    /**
     * @return array{organizer: ?string, organizer_street: ?string, organizer_postcode: ?string, organizer_place: ?string, organizer_phone: ?string, organizer_email: ?string, organizer_website: ?string}
     */
    private function extractOrganizerData(?Item $organizerData): array
    {
        $addressData = $this->resolveAddressData($organizerData);
        $address = $this->extractAddress($addressData?->field_add_address);

        return [
            'organizer' => $this->normalizeFilledString($organizerData?->field_com_company)
                ?? $this->normalizeFilledString($organizerData?->name),
            'organizer_street' => $address['street'],
            'organizer_postcode' => $address['postcode'],
            'organizer_place' => $address['place'],
            'organizer_phone' => $this->normalizeFilledString($organizerData?->field_msf_phone)
                ?? $this->normalizeFilledString($organizerData?->field_msf_phone_mobile),
            'organizer_email' => $this->normalizeFilledString($organizerData?->field_msf_email),
            'organizer_website' => $this->normalizeFilledString(data_get($organizerData?->field_msf_homepage, 'uri')),
        ];
    }

    private function resolveAddressData(?Item $data): ?Item
    {
        if (! $data) {
            return null;
        }

        if ($data->field_add_address) {
            return $data;
        }

        return $this->fetchRelatedItem($data, 'field_msf_address_ref');
    }

    /**
     * @return array{street: ?string, postcode: ?string, place: ?string}
     */
    private function extractAddress(mixed $address): array
    {
        $street = $this->normalizeFilledString(data_get($address, 'street'));
        $houseNumber = $this->normalizeFilledString(data_get($address, 'houseNumber') ?? data_get($address, 'house_number'));
        $houseNumberAddition = $this->normalizeFilledString(data_get($address, 'houseNumberAddition') ?? data_get($address, 'house_number_addition'));
        $houseNumberLine = $this->normalizeFilledString(($houseNumber ?? '').($houseNumberAddition ?? ''));

        return [
            'street' => $this->normalizeFilledString(implode(' ', array_filter([$street, $houseNumberLine]))),
            'postcode' => $this->normalizeFilledString(data_get($address, 'zip') ?? data_get($address, 'postalCode') ?? data_get($address, 'postal_code')),
            'place' => $this->normalizeFilledString(data_get($address, 'city')),
        ];
    }

    /**
     * @return array{latitude: ?float, longitude: ?float}
     */
    private function extractCoordinates(mixed $geo): array
    {
        return [
            'latitude' => $this->normalizeFloat(data_get($geo, 'lat')),
            'longitude' => $this->normalizeFloat(data_get($geo, 'lon') ?? data_get($geo, 'lng')),
        ];
    }

    private function cleanDescription(?string $description, string $title): ?string
    {
        if (! is_string($description) || trim($description) === '') {
            return null;
        }

        $lines = collect(preg_split('/\R+/u', html_entity_decode(strip_tags($description), ENT_QUOTES | ENT_HTML5, 'UTF-8')) ?: [])
            ->map(fn (string $line) => preg_replace('/\s+/u', ' ', trim($line)) ?? '')
            ->reject(fn (string $line) => $line === '' || in_array($line, ['Inhalt', 'Vorlesen'], true))
            ->values();

        if ($lines->isNotEmpty() && Str::lower($lines->first()) === Str::lower(trim($title))) {
            $lines->shift();
        }

        $cleaned = $lines->implode("\n\n");

        return $cleaned !== '' ? $cleaned : null;
    }

    private function normalizeFilledString(mixed $value): ?string
    {
        if (! is_string($value) && ! is_numeric($value)) {
            return null;
        }

        $normalized = preg_replace('/\s+/u', ' ', trim((string) $value)) ?? '';

        return $normalized !== '' ? $normalized : null;
    }

    private function normalizeFloat(mixed $value): ?float
    {
        return is_numeric($value) ? (float) $value : null;
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
