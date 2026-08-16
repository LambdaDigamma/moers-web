<?php

namespace Modules\News\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Modules\News\Http\Requests\StorePostRequest;
use Modules\News\Models\Post;

class PostController extends Controller
{
    public function store(StorePostRequest $request): JsonResponse|RedirectResponse
    {
        $post = new Post;
        $post->setTranslation('title', app()->getLocale(), $request->validated('title'));
        $post->setTranslation('summary', app()->getLocale(), $request->validated('summary'));
        $post->setTranslation('slug', app()->getLocale(), $request->validated('slug') ?: Str::slug($request->validated('title')));
        $post->setTranslation('external_href', app()->getLocale(), $request->validated('external_href'));
        $post->save();

        return $request->wantsJson()
                ? new JsonResponse($post, 302)
                : back()->with('success', 'Der Post wurde erstellt.')->with('data', ['id' => $post->id]);
    }
}
