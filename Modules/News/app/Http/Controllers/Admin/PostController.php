<?php

namespace Modules\News\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\News\Http\Requests\StorePostRequest;
use Modules\News\Models\Post;

class PostController extends Controller
{
    public function store(StorePostRequest $request): JsonResponse|RedirectResponse
    {
        $post = Post::create($request->validated());

        return $request->wantsJson()
                ? new JsonResponse($post, 302)
                : back()->with('success', 'Der Post wurde erstellt.')->with('data', ['id' => $post->id]);
    }
}
