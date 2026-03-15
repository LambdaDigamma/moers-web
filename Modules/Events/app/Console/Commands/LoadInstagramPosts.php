<?php

namespace Modules\Events\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Modules\News\Models\Feed;
use Modules\News\Models\Post;
use SimpleXMLElement;
use Throwable;

class LoadInstagramPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moers-festival:load-instagram-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load Instagram posts from RSS feed for Moers Festival';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $url = 'https://rss.app/feeds/qDjhcNf7L0QSXvOY.xml';

        $this->info('Fetching Instagram RSS feed...');

        try {
            $response = Http::timeout(30)->get($url);

            if (! $response->successful()) {
                $this->error('Failed to fetch RSS feed. Status: ' . $response->status());
                return self::FAILURE;
            }

            $rss = simplexml_load_string($response->body(), SimpleXMLElement::class, LIBXML_NOCDATA);

            if (! $rss) {
                $this->error('Failed to parse RSS feed.');
                return self::FAILURE;
            }

            $items = $rss->channel?->item ?? [];
            $count = 0;

            // Resolve the feed by identifier
            $feed = Feed::query()->byIdentifier('moers-festival-instagram')->first();

            if (!$feed) {
                $this->warn('Moers Festival Instagram feed not found by identifier. Creating it...');
                $feed = Feed::create([
                    'identifier' => 'moers-festival-instagram',
                    'name' => [
                        'en' => 'Instagram',
                        'de' => 'Instagram',
                    ],
                ]);
            }

            foreach ($items as $item) {
                $link = trim((string) $item->link);
                $title = trim((string) $item->title);
                $guid = trim((string) $item->guid);
                $imageUrl = (string) ($item->enclosure->attributes()->url ?? '');
                $description = (string) $item->description;

                // Clean up description/summary
                $summaryText = Str::of(strip_tags(htmlspecialchars_decode($description)))
                    ->squish()
                    ->toString();

                $publishedAt = Carbon::now();
                if (isset($item->pubDate)) {
                    $publishedAt = Carbon::parse((string) $item->pubDate);
                }

                $this->line('Processing post: ' . $title);

                $post = Post::query()
                    ->withNotPublished()
                    ->where('extras->guid', $guid)
                    ->first();

                if (! $post) {
                    $post = new Post();
                    $post->forceFill([
                        'title' => $title,
                        'external_href' => $link,
                        'published_at' => $publishedAt,
                        'extras' => collect([
                            'guid' => $guid,
                            'type' => 'instagram',
                        ]),
                    ]);
                } else {
                    $post->forceFill([
                        'title' => $title,
                        'summary' => $summaryText,
                        'external_href' => $link,
                        'published_at' => $publishedAt,
                    ]);

                    $extras = $post->extras ?? collect();
                    $extras->put('guid', $guid);
                    $extras->put('type', 'instagram');
                    $post->extras = $extras;
                }

                $post->save();

                // Handle Media
                if ($imageUrl && $post->getFirstMedia('header') === null) {
                    try {
                        $this->info('Adding media to post: ' . $title);
                        $post->addMediaFromUrl($imageUrl)->toMediaCollection('header');
                    } catch (Throwable $e) {
                        $this->warn('Could not download image: ' . $e->getMessage());
                    }
                }

                // Sync to our feed
                $feed->posts()->syncWithoutDetaching([$post->id]);

                $count++;
            }

            $this->info("Successfully processed $count Instagram posts.");

        } catch (Throwable $e) {
            $this->error('An error occurred: ' . $e->getMessage());
            report($e);
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
