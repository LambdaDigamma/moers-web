<?php

namespace Modules\News\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\News\Actions\SyncPostPageContent;
use Modules\News\Http\Requests\PublishPost;
use Modules\News\Models\Post;

class PublishedPostsController extends Controller
{
    public function publish(PublishPost $request, Post $post, SyncPostPageContent $syncPostPageContent): JsonResponse|RedirectResponse
    {
        $publishedAt = $request->input('published_at');

        DB::transaction(function () use ($post, $publishedAt, $syncPostPageContent): void {
            $post->scheduleFor($publishedAt ? Carbon::parse($publishedAt) : now());
            $syncPostPageContent->syncPublication($post);
        });

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : redirect()->back()->with('info', 'Der Veröffentlichungszeitpunkt wurde festgelegt.');
    }

    public function unpublish(Request $request, Post $post, SyncPostPageContent $syncPostPageContent): JsonResponse|RedirectResponse
    {
        DB::transaction(function () use ($post, $syncPostPageContent): void {
            $post->unpublish();
            $syncPostPageContent->syncPublication($post);
        });

        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : redirect()->back()->with('info', 'Der Post wurde ins Entwurfsstadium zurückversetzt.');
    }
}
