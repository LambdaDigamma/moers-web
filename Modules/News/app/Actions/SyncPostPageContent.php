<?php

namespace Modules\News\Actions;

use App\Models\Page;
use App\Models\PageBlock;
use Illuminate\Support\Str;
use Modules\News\Models\Feed;
use Modules\News\Models\Post;

class SyncPostPageContent
{
    private const BODY_BLOCK_TYPE = 'tiptap-text';

    private const LEGACY_BODY_BLOCK_TYPES = [
        'tiptap-text',
        'tip-tap-text',
    ];

    private const FESTIVAL_FEED_IDENTIFIERS = [
        'moers-festival-news',
        'moers-festival-instagram',
    ];

    /**
     * @param  array<int, int|string>  $feedIds
     * @param  array<string, mixed>|null  $document
     */
    public function execute(Post $post, array $feedIds, ?array $document): void
    {
        $page = $this->ensurePage($post, $feedIds);
        $block = $this->resolveBodyBlock($page);
        $locale = app()->getLocale();
        $data = $block->getTranslation('data', $locale, false);

        if (! is_array($data)) {
            $data = [];
        }

        $data['text'] = $this->normalizeDocument($document);

        $block->setTranslation('data', $locale, $data);
        $block->published_at = $post->published_at;
        $block->save();
    }

    public function syncPublication(Post $post): void
    {
        $post->refresh();
        $page = $this->findPage($post->page_id);

        if (! $page instanceof Page) {
            return;
        }

        $page->published_at = $post->published_at;
        $page->archived_at = $post->archived_at;
        $page->save();

        $page->blocks()
            ->withNotPublished()
            ->whereIn('type', self::LEGACY_BODY_BLOCK_TYPES)
            ->get()
            ->each(function (PageBlock $block) use ($post): void {
                $block->published_at = $post->published_at;
                $block->save();
            });
    }

    /**
     * @param  array<int, int|string>  $feedIds
     */
    private function ensurePage(Post $post, array $feedIds): Page
    {
        $locale = app()->getLocale();
        $page = $this->findPage($post->page_id) ?? new Page;
        $title = (string) ($post->title ?: 'Post '.$post->id);
        $summary = (string) ($post->summary ?: '');

        $page->setTranslation('title', $locale, $title);
        $page->setTranslation('summary', $locale, $summary);
        $page->setTranslation('slug', $locale, $this->uniqueSlug($post, $feedIds, $page->exists ? $page->id : null));
        $page->published_at = $post->published_at;
        $page->archived_at = $post->archived_at;
        $page->save();

        if ((int) $post->page_id !== (int) $page->id) {
            $post->page_id = $page->id;
            $post->save();
        }

        return $page;
    }

    private function findPage(?int $pageId): ?Page
    {
        if ($pageId === null) {
            return null;
        }

        return Page::query()
            ->withNotPublished()
            ->withArchived()
            ->withTrashed()
            ->find($pageId);
    }

    private function resolveBodyBlock(Page $page): PageBlock
    {
        $block = $page->blocks()
            ->withNotPublished()
            ->whereIn('type', self::LEGACY_BODY_BLOCK_TYPES)
            ->orderBy('order')
            ->first();

        if ($block instanceof PageBlock) {
            return $block;
        }

        $order = (int) $page->blocks()
            ->withNotPublished()
            ->max('order') + 1;

        $block = new PageBlock;
        $block->type = self::BODY_BLOCK_TYPE;
        $block->order = $order;
        $page->blocks()->save($block);

        return $block;
    }

    /**
     * @param  array<string, mixed>|null  $document
     * @return array<string, mixed>
     */
    private function normalizeDocument(?array $document): array
    {
        if (($document['type'] ?? null) === 'doc') {
            return $document;
        }

        return [
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'paragraph',
                ],
            ],
        ];
    }

    /**
     * @param  array<int, int|string>  $feedIds
     */
    private function uniqueSlug(Post $post, array $feedIds, ?int $ignorePageId): string
    {
        $locale = app()->getLocale();
        $baseSlug = $this->pageSlug($post, $feedIds);
        $candidate = $baseSlug;
        $suffix = 2;

        while (
            Page::query()
                ->withTrashed()
                ->withNotPublished()
                ->withArchived()
                ->when($ignorePageId !== null, fn ($query) => $query->whereKeyNot($ignorePageId))
                ->where("slug->{$locale}", $candidate)
                ->exists()
        ) {
            $candidate = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        return $candidate;
    }

    /**
     * @param  array<int, int|string>  $feedIds
     */
    private function pageSlug(Post $post, array $feedIds): string
    {
        $postSlug = Str::of((string) ($post->slug ?: $post->title ?: 'post-'.$post->id))
            ->slug()
            ->whenEmpty(fn () => Str::of('post-'.$post->id))
            ->toString();

        if ($this->hasFestivalFeed($feedIds)) {
            return $this->legacyFestivalCollection().'/news/'.$postSlug;
        }

        return 'news/'.$postSlug;
    }

    /**
     * @param  array<int, int|string>  $feedIds
     */
    private function hasFestivalFeed(array $feedIds): bool
    {
        $sourceFeedId = config('festival.news.source_feed_id');

        return Feed::query()
            ->withTrashed()
            ->whereIn('id', $feedIds)
            ->where(function ($query) use ($sourceFeedId) {
                $query->whereIn('identifier', self::FESTIVAL_FEED_IDENTIFIERS);

                if (is_int($sourceFeedId)) {
                    $query->orWhereKey($sourceFeedId);
                }
            })
            ->exists();
    }

    private function legacyFestivalCollection(): string
    {
        $collection = (string) config('festival.current_collection');

        if (preg_match('/^moers-festival-(\d{4})$/', $collection, $matches) === 1) {
            return 'festival'.substr($matches[1], -2);
        }

        return trim($collection, '/');
    }
}
