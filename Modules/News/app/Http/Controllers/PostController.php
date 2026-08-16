<?php

namespace Modules\News\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Response;
use Modules\News\Actions\SyncPostPageContent;
use Modules\News\Http\Requests\StorePostRequest;
use Modules\News\Http\Requests\UpdatePostRequest;
use Modules\News\Models\Feed;
use Modules\News\Models\Post;

class PostController extends Controller
{
    public function index(Request $request): Response
    {
        if ($request->routeIs('news.index')) {
            return $this->newsIndex($request);
        }

        $posts = Post::query()
            ->with(['feeds', 'media'])
            ->withNotPublished()
            ->withArchived()
            ->chronological()
            ->paginate(9)
            ->through(fn (Post $post) => $this->postListItem($post))
            ->withQueryString();

        return inertia('posts/index', [
            'posts' => $posts,
        ]);
    }

    public function show(Request $request, Post $anypost): Response
    {
        $canManageNews = $request->user()?->isAdmin() ?? false;

        if (! $canManageNews && (! $anypost->isPublished() || $anypost->archived_at !== null)) {
            abort(404);
        }

        return inertia('news/show', [
            'post' => [
                'id' => $anypost->id,
                'title' => $anypost->title,
                'summary' => $anypost->summary,
                'published_at' => $anypost->published_at?->toIso8601String(),
                'external_href' => $anypost->external_href,
                'canManage' => $canManageNews,
            ],
        ]);
    }

    public function create(): Response
    {
        return inertia('posts/edit-post', [
            'post' => null,
            'availableFeeds' => $this->availableFeeds(),
            'initialContent' => $this->emptyDocument(),
        ]);
    }

    public function store(StorePostRequest $request, SyncPostPageContent $syncPostPageContent): RedirectResponse
    {
        $post = DB::transaction(function () use ($request, $syncPostPageContent): Post {
            $post = new Post;
            $this->fillPost($post, $request->validated());
            $post->save();

            $this->syncHeaderMedia($post, $request);
            $this->syncFeeds($post, $request->validated('feed_ids', []));
            $syncPostPageContent->execute($post, $request->validated('feed_ids', []), $request->validated('content'));

            return $post;
        });

        return redirect()
            ->route('posts.edit', $post)
            ->with('success', 'Der Post wurde erstellt.');
    }

    public function edit(Post $anypost): Response
    {
        $anypost->load([
            'feeds',
            'media',
            'page' => fn ($query) => $query
                ->withNotPublished()
                ->withArchived()
                ->withTrashed()
                ->with(['blocks' => fn ($query) => $query
                    ->withNotPublished()
                    ->withExpired()
                    ->withHidden()
                    ->withTrashed()]),
        ]);

        return inertia('posts/edit-post', [
            'post' => $this->editablePost($anypost),
            'availableFeeds' => $this->availableFeeds(),
            'initialContent' => $this->postContent($anypost),
        ]);
    }

    public function update(UpdatePostRequest $request, Post $anypost, SyncPostPageContent $syncPostPageContent): RedirectResponse
    {
        DB::transaction(function () use ($request, $anypost, $syncPostPageContent): void {
            $this->fillPost($anypost, $request->validated());
            $anypost->save();

            $this->syncHeaderMedia($anypost, $request);
            $this->syncFeeds($anypost, $request->validated('feed_ids', []));
            $syncPostPageContent->execute($anypost, $request->validated('feed_ids', []), $request->validated('content'));
        });

        return back()->with('success', 'Der Post wurde gespeichert.');
    }

    protected function newsIndex(Request $request): Response
    {
        $posts = Post::query()
            ->with(['feeds', 'media'])
            ->when($request->user()?->isAdmin() ?? false, fn ($query) => $query->withNotPublished())
            ->orderByDesc('published_at')
            ->paginate(9)
            ->through(fn (Post $post) => [
                'id' => $post->id,
                'title' => $post->title,
                'summary' => $post->summary,
                'published_at' => $post->published_at?->toIso8601String(),
                'external_href' => $post->external_href,
                'source_name' => $post->feeds->map(fn (Feed $feed) => $feed->name)->filter()->first(),
                'header_image_url' => $post->getFirstMediaUrl('header') ?: null,
                'canManage' => $request->user()?->isAdmin() ?? false,
            ])
            ->withQueryString();

        return inertia('news/index', [
            'posts' => $posts,
            'canManageNews' => $request->user()?->isAdmin() ?? false,
        ]);
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    private function fillPost(Post $post, array $validated): void
    {
        $locale = app()->getLocale();
        $title = (string) $validated['title'];
        $slug = (string) ($validated['slug'] ?? Str::slug($title));

        if ($slug === '') {
            $slug = $post->exists ? 'post-'.$post->id : Str::random(8);
        }

        $post->setTranslation('title', $locale, $title);
        $post->setTranslation('summary', $locale, $validated['summary'] ?? null);
        $post->setTranslation('slug', $locale, $slug);
        $post->setTranslation('external_href', $locale, $validated['external_href'] ?? null);
    }

    private function syncHeaderMedia(Post $post, Request $request): void
    {
        if ($request->boolean('remove_header_image')) {
            $post->clearMediaCollection('header');
        }

        if ($request->hasFile('header_image')) {
            $post
                ->addMedia($request->file('header_image'))
                ->toMediaCollection('header');
        }
    }

    /**
     * @param  array<int, int|string>  $feedIds
     */
    private function syncFeeds(Post $post, array $feedIds): void
    {
        $existingOrder = $post->feeds()
            ->withPivot('order')
            ->get()
            ->mapWithKeys(fn (Feed $feed) => [$feed->id => $feed->publication?->order])
            ->all();

        $post->feeds()->sync(
            collect($feedIds)
                ->map(fn (int|string $id): int => (int) $id)
                ->unique()
                ->mapWithKeys(fn (int $id) => [$id => ['order' => $existingOrder[$id] ?? null]])
                ->all()
        );
    }

    /**
     * @return array<int, array{id: int, name: string, identifier: string|null}>
     */
    private function availableFeeds(): array
    {
        return Feed::query()
            ->orderBy('id')
            ->get()
            ->sortBy(fn (Feed $feed) => mb_strtolower($feed->name))
            ->values()
            ->map(fn (Feed $feed) => [
                'id' => $feed->id,
                'name' => $feed->name,
                'identifier' => $feed->identifier,
            ])
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function postContent(Post $post): array
    {
        $locale = app()->getLocale();
        $block = $post->page?->blocks
            ->whereIn('type', ['tiptap-text', 'tip-tap-text'])
            ->sortBy('order')
            ->first();

        if ($block === null) {
            return $this->emptyDocument();
        }

        $data = $block->getTranslation('data', $locale, false);

        if (! is_array($data) || ! is_array($data['text'] ?? null)) {
            return $this->emptyDocument();
        }

        return $data['text'];
    }

    /**
     * @return array<string, mixed>
     */
    private function emptyDocument(): array
    {
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
     * @return array<string, mixed>
     */
    private function editablePost(Post $post): array
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'summary' => $post->summary,
            'slug' => $post->slug,
            'external_href' => $post->external_href,
            'page_id' => $post->page_id,
            'published_at' => $post->published_at?->toIso8601String(),
            'archived_at' => $post->archived_at?->toIso8601String(),
            'deleted_at' => $post->deleted_at?->toIso8601String(),
            'is_imported' => $post->extras?->has('rss_identity') ?? false,
            'selected_feed_ids' => $post->feeds->pluck('id')->values()->all(),
            'media_collections' => $post->toArray()['media_collections'] ?? [],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function postListItem(Post $post): array
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'summary' => $post->summary,
            'published_at' => $post->published_at?->toIso8601String(),
            'archived_at' => $post->archived_at?->toIso8601String(),
            'external_href' => $post->external_href,
            'source_name' => $post->feeds->map(fn (Feed $feed) => $feed->name)->filter()->first(),
            'header_image_url' => $post->getFirstMediaUrl('header') ?: null,
        ];
    }
}
