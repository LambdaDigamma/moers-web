<?php

namespace App\Console\Commands;

use App\Models\Page;
use Illuminate\Console\Command;
use Modules\Events\Models\Event;
use Modules\Management\Models\Organisation;
use Modules\News\Models\Post;
use Modules\Parking\Models\ParkingArea;
use Modules\Waste\Models\RubbishStreet;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap for the website.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $sitemap = Sitemap::create();

        // Home
        $sitemap->add(Url::create(route('home'))
            ->setPriority(1.0)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        // Static Indexes
        $sitemap->add(Url::create(route('news.index'))
            ->setPriority(0.8)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        $sitemap->add(Url::create(route('events.index'))
            ->setPriority(0.8)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        $sitemap->add(Url::create(route('parking-areas.index'))
            ->setPriority(0.7)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY));

        $sitemap->add(Url::create(route('rubbish.index'))
            ->setPriority(0.7)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

        $sitemap->add(Url::create(route('organisations.index'))
            ->setPriority(0.7)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));

        // News Posts
        // The Publishable trait adds a global scope that filters by published_at <= now()
        Post::all()->each(function (Post $post) use ($sitemap) {
            if (! $post->external_href) {
                $sitemap->add(Url::create(route('news.show', $post->id))
                    ->setPriority(0.6)
                    ->setLastModificationDate($post->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
            }
        });

        // Events
        Event::all()->each(function (Event $event) use ($sitemap) {
            $sitemap->add(Url::create(route('events.show', $event->id))
                ->setPriority(0.6)
                ->setLastModificationDate($event->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        });

        // Parking Areas
        ParkingArea::all()->each(function (ParkingArea $parkingArea) use ($sitemap) {
            $sitemap->add(Url::create(route('parking-areas.show', $parkingArea->slug))
                ->setPriority(0.5)
                ->setLastModificationDate($parkingArea->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY));
        });

        // Organisations
        Organisation::all()->each(function (Organisation $organisation) use ($sitemap) {
            $sitemap->add(Url::create(route('organisations.show', $organisation->slug))
                ->setPriority(0.5)
                ->setLastModificationDate($organisation->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        });

        // Rubbish Streets
        RubbishStreet::current()->each(function (RubbishStreet $street) use ($sitemap) {
            $sitemap->add(Url::create(route('rubbish.show', $street->id))
                ->setPriority(0.4)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        });

        // Custom Pages
        Page::all()->each(function (Page $page) use ($sitemap) {
            $locales = config('api-language.supported_locales', ['de', 'en']);
            foreach ($locales as $locale) {
                app()->setLocale($locale);

                $sitemap->add(Url::create(url($page->full_slug))
                    ->setPriority(0.5)
                    ->setLastModificationDate($page->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
            }
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
    }
}
