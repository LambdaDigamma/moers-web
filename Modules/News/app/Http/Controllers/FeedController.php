<?php

namespace Modules\News\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Modules\News\Http\Requests\StoreFeedRequest;
use Modules\News\Http\Requests\UpdateFeedRequest;
use Modules\News\Models\Feed;
use Modules\News\Models\Post;

class FeedController extends Controller
{
    public function index(): Response
    {
        $feeds = Feed::query()
            ->withCount([
                'posts' => fn ($query) => $query
                    ->withNotPublished()
                    ->withArchived(),
            ])
            ->withTrashed()
            ->orderBy('id')
            ->paginate(15)
            ->through(fn (Feed $feed) => $this->feedListItem($feed))
            ->withQueryString();

        return inertia('feeds/index', [
            'feeds' => $feeds,
        ]);
    }

    public function create(): Response
    {
        return inertia('feeds/edit-feed', [
            'feed' => null,
            'availablePosts' => $this->availablePosts(),
        ]);
    }

    public function store(StoreFeedRequest $request): RedirectResponse
    {
        $feed = DB::transaction(function () use ($request): Feed {
            $feed = new Feed;
            $this->fillFeed($feed, $request->validated());
            $feed->identifier = $request->validated('identifier');
            $feed->save();

            $this->syncPosts($feed, $request->validated('posts', []));

            return $feed;
        });

        return redirect()
            ->route('feeds.edit', $feed)
            ->with('success', 'Der Feed wurde erstellt.');
    }

    public function edit(Feed $anyfeed): Response
    {
        $anyfeed->load([
            'posts' => fn ($query) => $query
                ->withNotPublished()
                ->withArchived(),
        ]);

        return inertia('feeds/edit-feed', [
            'feed' => $this->editableFeed($anyfeed),
            'availablePosts' => $this->availablePosts(),
        ]);
    }

    public function update(UpdateFeedRequest $request, Feed $anyfeed): RedirectResponse
    {
        DB::transaction(function () use ($request, $anyfeed): void {
            $this->fillFeed($anyfeed, $request->validated());
            $anyfeed->save();

            $this->syncPosts($anyfeed, $request->validated('posts', []));
        });

        return back()->with('success', 'Der Feed wurde gespeichert.');
    }

    public function destroy(Request $request, Feed $anyfeed): RedirectResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $anyfeed->delete();

        return redirect()->route('feeds.index')->with('success', 'Der Feed wurde geloescht.');
    }

    public function restore(Request $request, Feed $anyfeed): RedirectResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $anyfeed->restore();

        return back()->with('success', 'Der Feed wurde wiederhergestellt.');
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    private function fillFeed(Feed $feed, array $validated): void
    {
        $feed->setTranslation('name', app()->getLocale(), (string) $validated['name']);
    }

    /**
     * @param  array<int, array{id: int|string, order: int|string}>  $posts
     */
    private function syncPosts(Feed $feed, array $posts): void
    {
        $feed->posts()->sync(
            collect($posts)
                ->map(fn (array $post) => [
                    'id' => (int) $post['id'],
                    'order' => (int) $post['order'],
                ])
                ->unique('id')
                ->mapWithKeys(fn (array $post) => [$post['id'] => ['order' => $post['order']]])
                ->all()
        );
    }

    /**
     * @return array<int, array{id: int, title: string, published_at: string|null, archived_at: string|null}>
     */
    private function availablePosts(): array
    {
        return Post::query()
            ->withNotPublished()
            ->withArchived()
            ->orderBy('id')
            ->get()
            ->sortBy(fn (Post $post) => mb_strtolower($post->title ?? ''))
            ->values()
            ->map(fn (Post $post) => [
                'id' => $post->id,
                'title' => $post->title ?: 'Ohne Titel',
                'published_at' => $post->published_at?->toIso8601String(),
                'archived_at' => $post->archived_at?->toIso8601String(),
            ])
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function editableFeed(Feed $feed): array
    {
        return [
            'id' => $feed->id,
            'name' => $feed->name,
            'identifier' => $feed->identifier,
            'deleted_at' => $feed->deleted_at?->toIso8601String(),
            'posts' => $feed->posts
                ->sortBy(fn (Post $post) => $post->publication?->order ?? PHP_INT_MAX)
                ->values()
                ->map(fn (Post $post, int $index) => [
                    'id' => $post->id,
                    'title' => $post->title ?: 'Ohne Titel',
                    'order' => $post->publication?->order ?? $index,
                    'published_at' => $post->published_at?->toIso8601String(),
                    'archived_at' => $post->archived_at?->toIso8601String(),
                ])
                ->all(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function feedListItem(Feed $feed): array
    {
        return [
            'id' => $feed->id,
            'name' => $feed->name,
            'identifier' => $feed->identifier,
            'posts_count' => $feed->posts_count,
            'deleted_at' => $feed->deleted_at?->toIso8601String(),
        ];
    }
}
