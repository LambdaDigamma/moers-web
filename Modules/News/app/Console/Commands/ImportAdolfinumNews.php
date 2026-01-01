<?php

namespace Modules\News\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Modules\News\Models\Post;
use XMLParser;

class ImportAdolfinumNews extends Command
{
    protected $signature = 'news:load-adolfinum';

    protected $description = 'Loads and updates Adolfinum news';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $xml = XmlParser::load('https://adolfinum.de/share/aktuelles.xml');

        $data = $xml->parse([
            'page' => ['uses' => 'channel.atom:link[::rel="next"]'],
            'items' => ['uses' => 'channel.item[title,link,description,guid,pubDate,enclosure::url,enclosure::type]'],
        ]);

        $items = collect($data['items'])->recursive();

        $items->each(function ($item, $key) {
            Post::query()
                ->withNotPublished()
                ->updateOrCreate([
                    'guid' => $item->get('guid'),
                ], [
                    'title' => $item->get('title'),
                    'external_href' => $item->get('link'),
                    'published_at' => Carbon::parse($item->get('pubDate')),
                ]);
        });

        return 0;
    }
}
