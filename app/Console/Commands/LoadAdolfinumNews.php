<?php

namespace App\Console\Commands;

use App\Models\Post;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use XmlParser;

class LoadAdolfinumNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:loadAdolfinum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loads and updates Adolfinum news';

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
        $xml = XmlParser::load("https://adolfinum.de/share/aktuelles.xml");

        $data = $xml->parse([
            'page' => ['uses' => 'channel.atom:link[::rel="next"]'],
            'items' => ['uses' => 'channel.item[title,link,description,guid,pubDate,enclosure::url,enclosure::type]']
        ]);

        $items = collect($data['items'])->recursive();

        $items->each(function ($item, $key) {
            Post::query()
                ->withNotPublished()
                ->updateOrCreate([
                    'guid' => $item->get('guid')
                ], [
                    'title' => $item->get('title'),
                    'external_href' => $item->get('link'),
                    'published_at' => Carbon::parse($item->get('pubDate')),
                ]);
        });

        return 0;
    }
}
