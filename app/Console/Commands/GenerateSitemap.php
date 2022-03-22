<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\RubbishStreet;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
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
    protected $description = 'Generate the sitemap';

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
     * @return int
     */
    public function handle()
    {
        if ((config('app.url', null) === 'https://moers.app') || config('app.env') === 'local') {
            $this->createSitemap();
            $this->info('The sitemap was regenerated.');
        }
    }

    private function createSitemap()
    {
        $sitemap = Sitemap::create(config('app.url'));
        $sitemap->add(
            Url::create('/')
                ->setLastModificationDate(Carbon::now())
                ->setPriority(1.0)
        );

        $this->addEvents($sitemap);
        $this->addRubbish($sitemap);
        
        $sitemap->writeToFile(public_path('sitemap.xml'));
    }

    private function addEvents(Sitemap $sitemap) 
    {    
        $sitemap->add(
            Url::create('/veranstaltungen')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1.0)
        );
        
        $events = Event::query()
            ->upcoming()
            ->chronological()
            ->get();

        $events->each(function ($event) use ($sitemap) {
            $sitemap->add(
                Url::create("/events/{$event->id}")
                    ->setLastModificationDate($event->updated_at)
            );
        });
    }

    private function addRubbish(Sitemap $sitemap) 
    {
        $sitemap->add(
            Url::create('/abfallkalender')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(1.0)
        );

        $rubbishStreets = RubbishStreet::query()
            ->current()
            ->orderBy('name')
            ->get();

        $rubbishStreets->each(function ($street) use ($sitemap) {
            $sitemap->add(
                Url::create("/abfallkalender/{$street->id}")
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            );
        });
    }

    private function addParking(Sitemap $sitemap)
    {
        $sitemap->add(
            Url::create('/abfallkalender')
                ->setLastModificationDate(Carbon::now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS)
                ->setPriority(1.0)
        );
    }
}
