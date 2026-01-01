<?php

namespace Modules\News\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\News\Http\Requests\PublishPost;
use Modules\News\Models\Post;

class PublishedPostsController extends Controller
{
    public function publish(PublishPost $request, Post $post): JsonResponse|RedirectResponse
    {
        $published_at = request()->published_at;

        $post->scheduleFor($published_at ? Carbon::parse($published_at) : now());

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : redirect()->back()->with('info', 'Der Veröffentlichungszeitpunkt wurde festgelegt.');
    }

    public function unpublish(Request $request, Post $post): JsonResponse|RedirectResponse
    {
        $post->unpublish();

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : redirect()->back()->with('info', 'Der Post wurde ins Entwurfsstadium zurückversetzt.');
    }
}
