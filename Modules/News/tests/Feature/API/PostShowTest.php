<?php


use Modules\News\Models\Feed;
use Modules\News\Models\Post;
use Modules\News\Models\Publication;
use function Pest\Laravel\getJson;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

test('show post not published returns 404 (/api/v1/posts/id)', function () {

    $feed1 = Feed::factory()->create();
    $post = Post::factory()->create([
        'published_at' => null,
    ]);
    Publication::create([
        'post_id' => $post->id,
        'feed_id' => $feed1->id,
    ]);

    getJson("/api/v1/posts/{$post->id}")
        ->assertStatus(404);
});

test('show post (/api/v1/posts/id)', function () {

    config()->set('media-library.media_model', Media::class);

    $feed1 = Feed::factory()->create();
    $post = Post::factory()->create([
        'title' => 'Post Title',
        'published_at' => now(),
    ]);
    Publication::create([
        'post_id' => $post->id,
        'feed_id' => $feed1->id,
    ]);

    getJson("/api/v1/posts/{$post->id}")
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'summary',
                'slug',
                'page_id',
                'external_href',
                'extras',
                'created_at',
                'updated_at',
                'published_at',
                'archived_at',
                'deleted_at',
                'cta',
                'media',
            ],
        ]);
});
