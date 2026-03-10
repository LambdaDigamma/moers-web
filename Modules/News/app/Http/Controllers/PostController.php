<?php

namespace Modules\News\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Modules\News\Http\Requests\StorePostRequest;
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
            ->with('media')
            ->withNotPublished()
            ->chronological()
            ->paginate(9)
            ->withQueryString();

        return inertia('posts/index', [
            'posts' => $posts,
        ]);
    }

    public function show(Request $request, Post $anypost): Response
    {
        if ($request->user() === null && (! $anypost->isPublished() || $anypost->archived_at !== null)) {
            abort(404);
        }

        return inertia('news/show', [
            'post' => [
                'id' => $anypost->id,
                'title' => $anypost->title,
                'summary' => $anypost->summary,
                'published_at' => $anypost->published_at?->toIso8601String(),
                'external_href' => $anypost->external_href,
                'canManage' => $request->user() !== null,
            ],
        ]);
    }

    public function create(): Response
    {
        return inertia('posts/edit-post', [
            'post' => null,
        ]);
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $post = new Post;
        $post->forceFill($request->validated());
        $post->save();

        return redirect()
            ->route('posts.edit', $post)
            ->with('success', 'Der Post wurde erstellt.');
    }

    public function edit(Post $post): Response
    {
        return inertia('posts/edit-post', [
            'post' => $post->load('media'),
        ]);
    }

    public function update(StorePostRequest $request, Post $post): RedirectResponse
    {
        $post->forceFill($request->validated());
        $post->save();

        return back()->with('success', 'Der Post wurde gespeichert.');
    }

    protected function newsIndex(Request $request): Response
    {
        $posts = Post::query()
            ->with(['feeds', 'media'])
            ->when($request->user() !== null, fn ($query) => $query->withNotPublished())
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
                'canManage' => $request->user() !== null,
            ])
            ->withQueryString();

        return inertia('news/index', [
            'posts' => $posts,
        ]);
    }
}
