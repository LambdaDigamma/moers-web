<?php

namespace Modules\News\Http\Controllers\API;


use Illuminate\Http\JsonResponse;
use Modules\News\Models\Post;

class PostController
{
    public function show($id): JsonResponse
    {
        $post = Post::query()
            ->where('id', $id)
            ->with(['media'])
            ->firstOrFail();

        if ($post->isPublished()) {
            return response()->json([
                'data' => $post,
            ]);
        } else {
            return response()->json([
                'data' => null,
            ], 404);
        }
    }
}
