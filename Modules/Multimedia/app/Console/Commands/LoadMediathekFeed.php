<?php

namespace Modules\Multimedia\Console\Commands;

use Illuminate\Console\Command;

class LoadMediathekFeed extends Command
{
    protected $signature = 'radio-broadcasts:load-mediathek';

    protected $description = 'Loads all Radio KW broadcasts from NRWision';

    protected const string URL = 'https://www.nrwision.de/mediathek/radiosender/radio-kw/rss/100/feed.rss';

    public function handle(): int
    {
        $this->info('Starts loading media…');

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
