<?php

namespace Modules\News\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Modules\News\Models\Feed;
use Modules\News\Models\Post;
use SimpleXMLElement;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

class ImportExternalPostsCommand extends Command
{
    protected $signature = 'posts:import-external';

    protected $description = 'Loads configured external RSS news into the database';

    public function handle(): int
    {
        $sources = collect(config('news.rss_sources', []))
            ->filter(fn (mixed $source): bool => is_array($source) && filled($source['key'] ?? null) && filled($source['name'] ?? null) && filled($source['url'] ?? null))
            ->values();

        if ($sources->isEmpty()) {
            $this->warn('No RSS sources configured.');

            return self::SUCCESS;
        }

        $this->info('Importing external posts...');

        $importedPosts = 0;

        foreach ($sources as $source) {
            $this->line('Loading '.$source['name'].'...');

            try {
                $feed = $this->resolveFeed($source);
                $items = $this->loadItems($source['url']);

                foreach ($items as $index => $item) {
                    if (! $item instanceof SimpleXMLElement) {
                        continue;
                    }

                    $post = $this->importItem($feed, $source, $item, $index);

                    if ($post !== null) {
                        $importedPosts++;
                    }
                }
            } catch (Throwable $throwable) {
                report($throwable);

                $this->error('Error while loading feed '.$source['url']);
                $this->error($throwable->getMessage());
            }
        }

        $this->info('Created or updated '.$importedPosts.' external post(s).');

        return self::SUCCESS;
    }

    protected function resolveFeed(array $source): Feed
    {
        $feed = Feed::query()
            ->withTrashed()
            ->where(function ($query) use ($source) {
                $query
                    ->where('name->en', $source['name'])
                    ->orWhere('name->de', $source['name']);
            })
            ->first();

        if ($feed === null) {
            $feed = new Feed;
            $feed->setTranslations('name', [
                'en' => $source['name'],
                'de' => $source['name'],
            ]);
            $feed->save();
        }

        if ($feed->trashed()) {
            $feed->restore();
        }

        return $feed;
    }

    /**
     * @return Collection<int, SimpleXMLElement>
     */
    protected function loadItems(string $url): Collection
    {
        $response = Http::accept('application/rss+xml, application/xml, text/xml')
            ->timeout(15)
            ->get($url);

        $feed = simplexml_load_string($response->body(), SimpleXMLElement::class, LIBXML_NOCDATA);

        if (! $feed instanceof SimpleXMLElement) {
            $response->throw();

            throw new \RuntimeException('The RSS feed could not be parsed.');
        }

        $items = $feed->channel?->item;

        if ($items !== null) {
            return collect(iterator_to_array($items, false))->values();
        }

        $fallbackItems = $feed->xpath('//item') ?: $feed->xpath('//entry') ?: [];

        return collect($fallbackItems)->values();
    }

    protected function importItem(Feed $feed, array $source, SimpleXMLElement $item, int $index): ?Post
    {
        $title = trim((string) $item->title);
        $externalUrl = trim((string) $item->link);
        $guid = trim((string) $item->guid);

        if ($title === '' || $externalUrl === '') {
            return null;
        }

        $identity = sha1(($source['key'] ?? '').'|'.($guid !== '' ? $guid : $externalUrl));
        $description = Str::of(strip_tags((string) $item->description))
            ->squish()
            ->limit(400)
            ->toString();

        $post = Post::query()
            ->withNotPublished()
            ->withArchived()
            ->withTrashed()
            ->where('extras->rss_identity', $identity)
            ->first();

        if ($post === null) {
            $post = new Post;
        }

        $previousImageUrl = $post->extras?->get('rss_image_url');
        $imageUrl = $this->resolveImageUrl($item);
        $extras = collect($post->extras?->all() ?? [])
            ->merge([
                'rss_identity' => $identity,
                'rss_source_key' => $source['key'],
                'rss_guid' => $guid !== '' ? $guid : null,
                'rss_url' => $source['url'],
                'rss_image_url' => $imageUrl,
            ]);

        $publishedAt = $this->resolvePublishedAt($item);

        $post->forceFill([
            'title' => $title,
            'summary' => $description !== '' ? $description : null,
            'external_href' => $externalUrl,
            'published_at' => $publishedAt,
            'extras' => $extras,
        ]);

        $post->save();
        $this->syncHeaderImage($post, $imageUrl, $previousImageUrl);

        $feed->posts()->syncWithoutDetaching([
            $post->id => ['order' => $index],
        ]);

        $feed->posts()->updateExistingPivot($post->id, ['order' => $index]);

        return $post;
    }

    protected function resolvePublishedAt(SimpleXMLElement $item): Carbon
    {
        $publishedAt = trim((string) $item->pubDate);

        if ($publishedAt === '') {
            return now();
        }

        return Carbon::parse($publishedAt);
    }

    protected function resolveImageUrl(SimpleXMLElement $item): ?string
    {
        $enclosureUrl = trim((string) $item->enclosure['url']);

        if ($enclosureUrl !== '') {
            return $enclosureUrl;
        }

        $item->registerXPathNamespace('media', 'http://search.yahoo.com/mrss/');
        $item->registerXPathNamespace('gera', 'http://rp-online/rss/namespace');

        $geraImageUrl = trim((string) $item->xpath('string(gera:imageUrl[1])'));

        if ($geraImageUrl !== '') {
            return $geraImageUrl;
        }

        $mediaContentUrl = $this->extractXpathAttribute($item, 'media:content[1]', 'url');

        if ($mediaContentUrl !== null) {
            return $mediaContentUrl;
        }

        $mediaThumbnailUrl = $this->extractXpathAttribute($item, 'media:thumbnail[1]', 'url');

        if ($mediaThumbnailUrl !== null) {
            return $mediaThumbnailUrl;
        }

        $mediaGroupContentUrl = $this->extractXpathAttribute($item, 'media:group/media:content[1]', 'url');

        if ($mediaGroupContentUrl !== null) {
            return $mediaGroupContentUrl;
        }

        $description = (string) $item->description;

        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $description, $matches) === 1) {
            return $matches[1];
        }

        return null;
    }

    protected function syncHeaderImage(Post $post, ?string $imageUrl, ?string $previousImageUrl): void
    {
        if ($imageUrl === null) {
            return;
        }

        if ($post->getFirstMediaUrl('header') !== '' && $previousImageUrl === $imageUrl) {
            return;
        }

        try {
            $post->addMediaFromUrl($imageUrl)->toMediaCollection('header');
        } catch (FileDoesNotExist|FileIsTooBig|FileCannotBeAdded $throwable) {
            report($throwable);
            $this->warn('Image import failed for post '.$post->id.': '.$throwable->getMessage());
        }
    }

    protected function extractXpathAttribute(SimpleXMLElement $item, string $path, string $attribute): ?string
    {
        $matches = $item->xpath($path);

        if (! is_array($matches) || ! isset($matches[0]) || ! $matches[0] instanceof SimpleXMLElement) {
            return null;
        }

        $value = trim((string) $matches[0]->attributes()?->{$attribute});

        return $value !== '' ? $value : null;
    }
}
