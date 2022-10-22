<?php

namespace App\Console\Commands;

use App\Models\Post;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Log;
use SimpleXMLElement;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

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
        "https://rp-online.de/nrw/staedte/moers/feed.rss",
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
            try {
                $response = Http::get($source);
                $response = $response->body();

                $feed = new SimpleXMLElement($response);

                $feedTitle = (string) $feed->channel->title;

                foreach ($feed->channel->item as $entry) {

                    $post = Post::updateOrCreate([
                        'guid' => (string) $entry->guid,
                    ], [
                        'title' => (string) $entry->title,
                        // 'content' => (string) $entry->description,
                        'source' => $feedTitle,
                        'guid' => (string) $entry->guid,
                        'external_href' => (string) $entry->link,
                        'published_at' => Carbon::parse((string) $entry->pubDate),
                    ]);

                    // Media of the rss item
                    $enclosure = (string) $entry->enclosure['url'];
                    $image_url = null;

                    if ($post->getFirstMedia('header') == null) {
                        if ($enclosure != "") {
                            $image_url = $enclosure;
                        } else {
                            $media_namespace = $entry->children('http://search.yahoo.com/mrss/');
                            $image_url = (string) $media_namespace->content->attributes()->url;
                        }
                    }

                    if ($image_url) {
                        try {
                            $post->addMediaFromUrl($image_url)
                                ->toMediaCollection('header');
                        } catch (FileDoesNotExist|FileIsTooBig|FileCannotBeAdded $e) {
                            Log::error($e->getMessage());
                        }
                    }

                }
            } catch (Exception $e) {
                $this->error('Error while loading feed ' . $source);
                $this->error($e->getMessage());
                Log::error($e->getMessage());
            }

        });


        return 0;
    }
}
