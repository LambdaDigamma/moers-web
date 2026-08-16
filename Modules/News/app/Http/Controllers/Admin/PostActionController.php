<?php

namespace Modules\News\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\News\Actions\SyncPostPageContent;
use Modules\News\Models\Post;

class PostActionController extends Controller
{
    public function archive(Request $request, Post $post, SyncPostPageContent $syncPostPageContent): JsonResponse|RedirectResponse
    {
        DB::transaction(function () use ($post, $syncPostPageContent): void {
            $post->archive();
            $syncPostPageContent->syncPublication($post);
        });

        return $request->wantsJson()
                ? new JsonResponse('', 200)
                : redirect()->back()->with('success', 'Der Post wurde archiviert.');
    }

    public function unarchive(Request $request, Post $post, SyncPostPageContent $syncPostPageContent): JsonResponse|RedirectResponse
    {
        DB::transaction(function () use ($post, $syncPostPageContent): void {
            $post->unArchive();
            $syncPostPageContent->syncPublication($post);
        });

        return $request->wantsJson()
                ? new JsonResponse('', 200)
                : redirect()->back()->with('success', 'Das Archivieren wurde rückgängig gemacht.');
    }
}
