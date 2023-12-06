<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LoadMediathekFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'radio-broadcasts:load-mediathek';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loads all Radio KW broadcasts from NRWision';

    protected const URL = "https://www.nrwision.de/mediathek/radiosender/radio-kw/rss/100/feed.rss";

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
        $this->info("Starts loading media…");

        $feed = simplexml_load_file(self::URL);
        $items = collect([]);
        
        foreach ($feed->channel->item as $item) {
            $items->add($item);
        }

        $this->info("Recognized {$items->count()} items");

        $item = $items->first();
        $itunes = $item->children('itunes', true);



        // dd($itunes);
        // $title = trim((string) $items[0]->title);
        // $subtitle = trim((string) $items[0]->attributes['itunes:subtitle']);
        // $description = trim(strip_tags((string) $items[0]->description));
        // $mediaURL = (string) $items[0]->enclosure['url'];

        // dd($title, $subtitle, $description, $mediaURL);

        // $this->table(['Title'], $items->map(function ($item) {
        //     return ['title' => $item->title];
        // }));

        return 0;
    }
}
