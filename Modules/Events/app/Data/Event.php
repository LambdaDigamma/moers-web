<?php

namespace Modules\Events\Data;

use Carbon\CarbonInterface;
use Illuminate\Support\Str;
use Modules\Events\Models\Event as EventModel;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class Event extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public ?CarbonInterface $startDate,
        public ?CarbonInterface $endDate,
        public ?string $description,
        public ?string $excerpt,
        public ?string $teaser,
        public ?string $subtitle,
        public ?int $pageId,
        public ?string $url,
        public ?string $calendarUrl,
        public ?string $category,
        public ?string $collection,
        public ?string $attendanceMode,
        public bool $isOnline,
        public array $artists,
        public ?string $locationName,
        public ?string $street,
        public ?string $postcode,
        public ?string $city,
        public ?float $latitude,
        public ?float $longitude,
        public ?string $organisationName,
        public ?string $organisationSlug,
        public ?string $organisationLogoPath,
        public ?string $organizerStreet,
        public ?string $organizerPostcode,
        public ?string $organizerCity,
        public ?string $organizerPhone,
        public ?string $organizerEmail,
        public ?string $organizerWebsite,
        public ?string $headerImageUrl,
        public ?CarbonInterface $createdAt,
        public ?CarbonInterface $updatedAt,
        public ?CarbonInterface $publishedAt,
        public ?CarbonInterface $cancelledAt,
        public ?CarbonInterface $archivedAt,
        public ?CarbonInterface $deletedAt,
        /** @var DataCollection<int, \Modules\Events\Data\Event>|null */
        public ?DataCollection $subEvents = null,
        public ?self $parentEvent = null,
    ) {}

    public static function fromModel(EventModel $event, bool $includeRelations = true): self
    {
        $place = $event->place;
        $organisation = $event->organisation;
        $description = is_string($event->description) ? trim($event->description) : null;

        if ($description) {
            $description = preg_replace('/^((Inhalt|Vorlesen)\s+)+/im', '', $description);

            if ($event->name && Str::startsWith(Str::lower(trim($description)), Str::lower($event->name))) {
                $description = trim(substr(trim($description), strlen($event->name)));
            }

            $description = trim($description);
        }

        $teaser = $event->extras?->get('teaser');

        $subtitle = $event->extras?->get('subtitle');

        if ($subtitle === 'Inhalt' || $subtitle === 'Vorlesen') {
            $subtitle = null;
        }

        $calendarUrl = null;

        if ($event->start_date !== null) {
            $calendarUrl = $event->ics();
        }

        $subEvents = null;
        if ($includeRelations && $event->relationLoaded('subEvents')) {
            $subEvents = self::collect($event->subEvents->map(fn (EventModel $e) => self::fromModel($e, false)), DataCollection::class);
        }

        $parentEvent = null;
        if ($includeRelations && $event->relationLoaded('parentEvent') && $event->parentEvent) {
            $parentEvent = self::fromModel($event->parentEvent, false);
        }

        return new self(
            id: $event->id,
            name: $event->name,
            startDate: $event->start_date,
            endDate: $event->end_date,
            description: $description,
            excerpt: ($teaser ?: $description) ? Str::of(strip_tags($teaser ?: $description))->squish()->limit(180)->toString() : null,
            teaser: $teaser,
            subtitle: $subtitle,
            pageId: $event->page_id,
            url: $event->url,
            calendarUrl: $calendarUrl,
            category: $event->category,
            collection: $event->collection,
            attendanceMode: $event->attendance_mode,
            isOnline: $event->is_online,
            artists: $event->artists ?? [],
            locationName: $place?->name ?? $event->extras?->get('location'),
            street: $place?->street_name ?? $event->extras?->get('street'),
            postcode: $place?->postalcode ?? $event->extras?->get('postcode'),
            city: $place?->postal_town ?? $event->extras?->get('place'),
            latitude: $place?->lat !== null ? (float) $place->lat : null,
            longitude: $place?->lng !== null ? (float) $place->lng : null,
            organisationName: $organisation?->name ?? $event->extras?->get('organizer'),
            organisationSlug: $organisation?->slug,
            organisationLogoPath: $organisation?->logo_path,
            organizerStreet: $event->extras?->get('organizer_street'),
            organizerPostcode: $event->extras?->get('organizer_postcode'),
            organizerCity: $event->extras?->get('organizer_place'),
            organizerPhone: $event->extras?->get('organizer_phone'),
            organizerEmail: $event->extras?->get('organizer_email'),
            organizerWebsite: $event->extras?->get('organizer_website'),
            headerImageUrl: $event->getFirstMediaUrl(EventModel::HEADER_MEDIA_COLLECTION) ?: null,
            createdAt: $event->created_at,
            updatedAt: $event->updated_at,
            publishedAt: $event->published_at,
            cancelledAt: $event->cancelled_at,
            archivedAt: $event->archived_at,
            deletedAt: $event->deleted_at,
            subEvents: $subEvents,
            parentEvent: $parentEvent,
        );
    }
}
