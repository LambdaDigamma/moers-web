<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

class ImportExternalPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:import-external';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loads all rss feed based external posts into the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected $feeds = [
        "https://adolfinum.de/share/aktuelles.xml",
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Importing external posts...');
        $this->info("Collecting post for " . count($this->feeds) . " feed/s…");

        $feedSources = collect($this->feeds);

        $feedSources->each(function ($source) {
            $response = Http::get($source);
            $response = utf8_encode($response->body());

            $feed = new SimpleXMLElement($response);

            foreach ($feed->channel->item as $entry) {

                $post = Post::updateOrCreate([
                    'guid' => (string) $entry->guid,
                ], [
                    'title' => (string) $entry->title,
                    // 'content' => (string) $entry->description,
                    // 'source' => $source,
                    'guid' => (string) $entry->guid,
                    'external_href' => (string) $entry->link,
                    'published_at' => Carbon::parse((string) $entry->pubDate),
                ]);

                // dd($entry);
            }

            // dd($feed);
        });

        // dd(Post::all());

        return 0;
    }
}
