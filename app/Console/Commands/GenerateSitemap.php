<?php

namespace App\Console\Commands;

use App\Models\Event;
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
            // ->add(Url::create('/de')
            //     ->setLastModificationDate(Carbon::now())
            //     ->setPriority(1.0)
            // )
            // ->add(Url::create('/en')
            //     ->setLastModificationDate(Carbon::now())
            //     ->setPriority(1.0)
            // );

        $sitemap->add(Url::create('/events'));

        $events = Event::query()
            ->upcoming()->chronological()->get();

        $events->each(function ($event) use ($sitemap) {
            $sitemap->add(Url::create("/events/{$event->id}"));
        });
        


        // $pages = Page::all();
        // $pages->each(function ($page) use ($sitemap) {

        //     $deSlug = "de/" . $page->getTranslation('slug', 'de');
        //     $enSlug = "en/" . $page->getTranslation('slug', 'en');

        //     $sitemap
        //         ->add(Url::create($deSlug)
        //             ->setLastModificationDate($page->updated_at)
        //         )
        //         ->add(Url::create($enSlug)
        //             ->setLastModificationDate($page->updated_at)
        //         );
        // });
        
        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
