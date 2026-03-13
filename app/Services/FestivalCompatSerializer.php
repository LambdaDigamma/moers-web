<?php

namespace App\Services;

use App\Models\Page;
use Modules\Events\Enums\ScheduleDisplay;
use Modules\Events\Models\Event;
use Modules\Locations\Models\Location;
use stdClass;

class FestivalCompatSerializer
{
    public function event(Event $event): array
    {
        return $this->eventFromArray($event->toArray());
    }

    public function place(Location $location): array
    {
        return $this->placeFromArray($location->toArray());
    }

    public function page(Page $page): array
    {
        return $page->toArray();
    }

    public function headerForEvent(Event $event): array
    {
        $pageHeader = $event->page?->getFirstMedia('header');

        if ($pageHeader !== null) {
            return $pageHeader->toArray();
        }

        $eventHeader = $event->getFirstMedia('header');

        if ($eventHeader !== null) {
            return $eventHeader->toArray();
        }

        return $this->defaultHeader();
    }

    public function legacyCollectionName(?string $collection): ?string
    {
        if ($collection === null) {
            return null;
        }

        if (preg_match('/^moers-festival-(\d{4})$/', $collection, $matches) === 1) {
            return 'festival'.substr($matches[1], -2);
        }

        return $collection;
    }

    public function eventFromArray(array $payload): array
    {
        $legacyCollection = $this->legacyCollectionName($payload['collection'] ?? null);

        if (array_key_exists('collection', $payload)) {
            $payload['collection'] = $legacyCollection;
        }

        $extras = $payload['extras'] ?? [];

        if (is_string($extras)) {
            $extras = json_decode($extras, true) ?? [];
        }

        if (is_array($extras) && $legacyCollection !== null) {
            $extras['collection'] = $legacyCollection;
        }

        if (is_array($extras)) {
            $extras['schedule_display'] = ScheduleDisplay::fromValue(
                is_string($extras['schedule_display'] ?? null) ? $extras['schedule_display'] : null,
                legacyPreview: (bool) ($extras['is_preview'] ?? false),
            )->value;
        }

        $payload['extras'] = $extras;

        if (array_key_exists('place', $payload) && is_array($payload['place'])) {
            $payload['place'] = $this->placeFromArray($payload['place']);
        }

        if (! array_key_exists('media_collections', $payload)) {
            $payload['media_collections'] = [];
        }

        return $payload;
    }

    public function placeFromArray(array $payload): array
    {
        $payload['tags'] = $this->normalizeTags($payload['tags'] ?? '');

        if (array_key_exists('extras', $payload) && is_array($payload['extras'])) {
            $payload['extras'] = json_encode($payload['extras']);
        }

        if (array_key_exists('events', $payload) && is_array($payload['events'])) {
            $payload['events'] = collect($payload['events'])
                ->map(fn (array $event) => $this->eventFromArray($event))
                ->values()
                ->all();
        }

        return $payload;
    }

    private function normalizeTags(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_array($value)) {
            return collect($value)
                ->flatten()
                ->filter(fn ($tag) => is_string($tag) && $tag !== '')
                ->implode(', ');
        }

        return '';
    }

    private function defaultHeader(): array
    {
        $url = rtrim(config('app.url'), '/').'/img/band-platzhalter.png';

        return [
            'id' => 0,
            'model_type' => Page::class,
            'model_id' => 0,
            'uuid' => '9CB4504B-5BE7-4453-B4B5-23A5294AC5A5',
            'collection_name' => 'header',
            'name' => 'band-platzhalter.png',
            'file_name' => 'band-platzhalter.png',
            'mime_type' => 'image/jpeg',
            'disk' => 'media',
            'conversions_disk' => 'media',
            'size' => 40000,
            'manipulations' => [],
            'custom_properties' => [
                'custom_headers' => [],
            ],
            'alt' => '',
            'credits' => '',
            'caption' => '',
            'generated_conversions' => [
                'opengraph' => false,
                'thumbnail' => false,
                'preview' => false,
            ],
            'responsive_images' => new stdClass,
            'order_column' => 0,
            'created_at' => '2022-05-03T15:26:58.000000Z',
            'updated_at' => '2022-05-03T15:26:59.000000Z',
            'srcset' => '',
            'full_url' => $url,
            'responsive_width' => 1200,
            'responsive_height' => 794,
            'preview_url' => $url,
        ];
    }
}
