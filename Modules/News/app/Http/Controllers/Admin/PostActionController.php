<?php

namespace Modules\News\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\News\Models\Post;

class PostActionController extends Controller
{
    public function archive(Request $request, Post $post): JsonResponse|RedirectResponse
    {
        $post->archive();

        return $request->wantsJson()
                ? new JsonResponse('', 200)
                : redirect()->back()->with('success', 'Der Post wurde archiviert.');
    }

    public function unarchive(Request $request, Post $post): JsonResponse|RedirectResponse
    {
        $post->unArchive();

        return $request->wantsJson()
                ? new JsonResponse('', 200)
                : redirect()->back()->with('success', 'Das Archivieren wurde rückgängig gemacht.');
    }
}
