<?php

use Modules\News\Models\Feed;
use Modules\News\Models\Post;

test('posts belonging to feed have publication pivot with order column', function () {
    $feed = Feed::factory()->create();
    $posts = Post::factory()->count(5)
        ->published()
        ->create();

    $map = collect([
        [null, $posts[4]],
        [0, $posts[3]],
        [1, $posts[1]],
        [3, $posts[0]],
        [4, $posts[2]],
    ]);

    $map->each(function ($m) use ($feed) {
        $order = $m[0];
        $post = $m[1];
        $feed->posts()->attach($post, ['order' => $order]);
    });

    $orderArray = Feed::find($feed->id)
        ->posts
        ->pluck('id')
        ->all();

    expect($orderArray)
        ->toBeArray()
        ->and($orderArray)
        ->toBe([$posts[3]->id, $posts[1]->id, $posts[0]->id, $posts[2]->id, $posts[4]->id]);
});
