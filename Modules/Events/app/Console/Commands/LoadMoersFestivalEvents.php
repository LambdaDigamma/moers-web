<?php

namespace Modules\Events\Console\Commands;

use App\Blocks\TipTapTextWithMedia;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\Events\Actions\CreateMoersFestivalCollectionEvent;
use Modules\Events\Actions\CreateMoersFestivalOrganisationIfNeeded;
use Modules\Events\Integrations\MoersFestival\MoersFestivalConnector;
use Modules\Events\Integrations\MoersFestival\Requests\GetEventsRequest;
use Modules\Events\Models\Event;
use Modules\Locations\Models\Location;
use Modules\Management\Models\Organisation;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Tiptap\Editor;

class LoadMoersFestivalEvents extends Command
{
    protected $description = 'Load events from moers festival website.';

    protected $signature = 'events:load-moers-festival-events';

    protected array $festivalIdMap = [
        '1' => 'festival23',
        '2' => 'festival24',
        '3' => 'festival25',
    ];

    protected string $nextUpFestivalCollection = 'festival25';

    const string CURRENT_COLLECTION = 'festival25';

    const bool SET_NEW_ELEMENTS_TO_PREVIEW = false;

    const bool OVERRIDE_PREVIEW = true;

    public function handle(): void
    {
        $organisation = (new CreateMoersFestivalOrganisationIfNeeded)->execute();
        $this->createMoersFestivalEvents();

        $forge = new MoersFestivalConnector;
        $request = new GetEventsRequest;

        $this->info('Loading events from Moers Festival API');

        $response = $forge->send($request);
        $events = $response->json();

        $this->deleteRemovedEvents($events, $organisation);

        foreach ($events as $event) {

            $externalId = $event['id'];
            $parentEventIndex = $event['event'];
            $year = 2022 + $parentEventIndex;

            $title = trim($event['title']);
            $subline = $event['subline'];
            $subline_en = $event['subline_en'];
            $standort = $event['standort'];

            if ($this::SET_NEW_ELEMENTS_TO_PREVIEW) {
                $time_start = Carbon::parse('2024-05-17 15:00:00', 'Europe/Berlin')->timezone('UTC');
                $time_end = null;
                $open_end = true;
            } else {
                $time_start = $event['time_start'];
                $time_end = $event['time_end'];
                $open_end = $event['open_end'];
            }

            $sametime = $event['sametime'];
            $media = $event['media'];
            $mediaUrl = 'https://www.moers-festival.de/media/'.$media;
            $besetzung = $event['besetzung'];
            $text = $event['text'];
            $text_en = $event['text_en'];
            $lastchanged = $event['lastchanged'];
            $url = $event['url_de'];
            $url_en = $event['url_en'];
            $standort_name = str($event['standort_name'])->trim()->toString();
            $standort_adresse = str($event['standort_adresse'])->trim()->toString();
            $standort_city = $event['standort_city'];
            $standort_plz = $event['standort_plz'];
            $standort_lng = $event['standort_lng'];
            $standort_lat = $event['standort_lat'];
            $preview = $event['preview'];

            if ($this::OVERRIDE_PREVIEW) {
                $preview = 0;
            }

            $event = Event::query()
                ->where('extras->external_id', '=', $externalId)
                ->where('organisation_id', '=', $organisation->id)
                ->withNotPublished()
                ->first();

            if (! $event) {
                $this->warn("Event '$title' not existing yet. Creating...");
                $event = Event::create([
                    'name' => $title,
                    'organisation_id' => $organisation->id,
                    'extras' => ['external_id' => $externalId],
                    'published_at' => now(),
                ]);
            }

            $doNotModify = $event->extras['do_not_modify'] ?? false;

            if ($doNotModify) {
                $this->warn("Event '$title' is marked as do_not_modify. Skipping...");

                continue;
            }

            $artists = collect(explode(PHP_EOL, str($besetzung)->trim()->toString()))
                ->map(fn ($artist) => str($artist)->trim()->toString())
                ->toArray();

            $externalPlaceId = intval($standort);

            $startDate = $time_start != null ? Carbon::parse($time_start, 'Europe/Berlin') : null;

            $event->name = $title;
            $event->start_date = $startDate;
            $event->end_date = $time_end != null ? Carbon::parse($time_end, 'Europe/Berlin') : null;
            $event->organisation_id = $organisation->id;
            $event->parent_event_id = (new CreateMoersFestivalCollectionEvent)->execute(year: $year)->id;

            if ($event->start_date != null && $event->end_date != null) {
                if ($event->start_date->gt($event->end_date)) {
                    $event->end_date = null;
                    Log::warning("Event '$title' has end date before start date. Setting end date to null.");
                    // todo: send telegram message
                }
            }

            $event->extras = [
                'external_id' => $externalId,
                'lineup' => $artists,
                'collection' => "moers-festival-$year",
                'open_end' => $open_end == 1,
                'sametime' => $sametime == '' ? null : intval($sametime),
                'do_not_modify' => false,
                'is_preview' => $preview == 1,
            ];
            $event->updated_at = $lastchanged != null ? Carbon::parse($lastchanged, 'Europe/Berlin') : null;

            $existingHeader = $event->getFirstMedia('header');

            if ($existingHeader) {

                if ($existingHeader->file_name != $media) {

                    $this->warn('Media file name changed. Deleting existing header and loading new one.');

                    $existingHeader->delete();
                    $this->loadMedia($event, $mediaUrl);
                }

            } else {

                if ($media != '') {
                    $this->info("Loading header media '$mediaUrl'");
                    $this->loadMedia($event, $mediaUrl);
                } else {
                    $this->warn("No media found for event '$title'");
                }

            }

            $this->updatePage(
                event: $event,
                text: $text,
                text_en: $text_en,
                subline: $subline,
                subline_en: $subline_en,
                collection: "moers-festival-$year"
            );

            if ($externalPlaceId != 0) {
                $place = $this->updatePlace(
                    externalPlaceId: $externalPlaceId,
                    name: $standort_name,
                    lat: floatval($standort_lat),
                    lng: floatval($standort_lng),
                    address: $standort_adresse,
                    postcode: $standort_plz,
                    city: $standort_city
                );
                $event->place_id = $place->id;
            }

            $event->save();

        }

    }

    private function createMoersFestivalEvents(): void
    {
        $currentYear = Carbon::now()->year;

        for ($i = 2023; $i <= $currentYear; $i++) {
            (new CreateMoersFestivalCollectionEvent)->execute(year: $i);
        }
    }

    public function updatePlace(
        int $externalPlaceId,
        string $name,
        float $lat, float $lng,
        string $address,
        string $postcode,
        string $city
    ): Location {

        $location = Location::query()
            ->where('extras->external_id', '=', $externalPlaceId)
            ->first();

        if (! $location) {
            $location = Location::make([
                'extras' => ['external_id' => $externalPlaceId],
                'published_at' => now(),
            ]);
        }

        $location->name = $name;
        $location->extras = [
            'external_id' => $externalPlaceId,
        ];
        $location->street_name = $address;
        $location->postalcode = $postcode;
        $location->postal_town = $city;
        $location->country_code = 'DE';
        $location->lat = $lat;
        $location->lng = $lng;
        $location->save();

        return $location;

    }

    public function loadMedia(Event $event, string $mediaUrl): void
    {
        try {
            $event
                ->addMediaFromUrl($mediaUrl)
                ->toMediaCollection('header');
        } catch (FileDoesNotExist $e) {
        } catch (FileIsTooBig $e) {
        } catch (FileCannotBeAdded $e) {
        }
    }

    public function updatePage(
        Event $event,
        string $text,
        string $text_en,
        string $subline,
        string $subline_en,
        string $collection
    ): void {

        $page = $event->page;

        if (! $page) {
            $this->warn("Page for event '$event->name' not existing yet. Creating...");
            $page = $event->page()->make([
                'published_at' => now(),
            ]);
        }

        $this->info("Updating page for event '$event->name'");

        $slug = $collection.Carbon::now()->format('y').'/e/'.str($event->name)->slug()->toString();

        $page->setTranslation('title', 'de', $event->name);
        $page->setTranslation('slug', 'de', $slug);

        if ($text != '') {
            $summaryDE = (new Editor)
                ->setContent($text)
                ->getText();
            $page->setTranslation('summary', 'de', $summaryDE);
        }
        if ($text_en != '') {
            $summaryEN = (new Editor)
                ->setContent($text_en)
                ->getText();
            $page->setTranslation('summary', 'en', $summaryEN);
        }

        $page->save();
        $event->page_id = $page->fresh()->id;

        // Find first page block with tip tap type or create it
        $textPageBlock = $page->blocks()
            ->where('type', '=', TipTapTextWithMedia::typeIdentifier())
            ->first();

        if (! $textPageBlock) {
            $textPageBlock = $page->blocks()->make([
                'type' => TipTapTextWithMedia::typeIdentifier(),
                'published_at' => now(),
                'order' => 1,
                'page_id' => $page->fresh()->id,
            ]);
        }

        $documentDE = $text != '' ? (new Editor)
            ->setContent($text)
            ->getDocument() : null;

        $documentEN = $text_en != '' ? (new Editor)
            ->setContent($text_en)
            ->getDocument() : null;

        $subline = str($subline)->trim()->toString();
        $subline_en = str($subline_en)->trim()->toString();

        $formattedSubline = $subline != '' ? $subline : null;
        $formattedSublineEN = $subline_en != '' ? $subline_en : null;

        $data = [
            'title' => $formattedSubline,
            'text' => $documentDE,
        ];

        $dataEN = [
            'title' => $formattedSublineEN ?? $formattedSubline,
            'text' => $documentEN ?? $documentDE,
        ];

        $textPageBlock->setTranslation('data', 'de', $data);
        $textPageBlock->setTranslation('data', 'en', $dataEN);
        $textPageBlock->save();

    }

    protected function deleteRemovedEvents(mixed $events, Organisation $organisation): void
    {
        $this->info('Found '.count($events).' events');

        // Find all events that are not in the external list anymore
        $externalIds = collect($events)->pluck('id')->toArray();

        $this->info('Found '.count($externalIds).' external ids');

        $eventsToDelete = Event::query()
            ->where('extras->collection', '=', $this->nextUpFestivalCollection)
            ->where('organisation_id', '=', $organisation->id)
            ->whereNotIn('extras->external_id', $externalIds)
            ->get();

        $this->info('Found '.count($eventsToDelete).' events to delete');

        foreach ($eventsToDelete as $eventToDelete) {
            $this->warn("Deleting event '$eventToDelete->name'");
            $eventToDelete->delete();
        }
    }
}
