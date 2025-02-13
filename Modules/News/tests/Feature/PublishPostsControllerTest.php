<?php

use Database\Factories\UserFactory;
use Illuminate\Support\Carbon;
use Modules\News\Models\Post;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

test('unpublished post can be published now', function () {
    actingAs(UserFactory::new()->create());
    $post = Post::factory()->create();
    expect($post->published_at)->toBeNull();

    postJson("/admin/posts/{$post->id}/publish")->assertStatus(200);
    expect(Post::find($post->id)->published_at)->not->toBeNull();
});

test('unpublished post can be published at specific time', function () {
    actingAs(UserFactory::new()->create());
    $post = Post::factory()->create();
    expect($post->published_at)->toBeNull();

    $publishAt = Carbon::now()->addMinutes(60);

    postJson("/admin/posts/{$post->id}/publish", [
        'published_at' => $publishAt->toDateTimeString(),
    ])->assertStatus(200);

    expect(Post::query()->withNotPublished()->find($post->id)->published_at->toDateTimeString())
        ->toBe($publishAt->toDateTimeString());
});

test('published post can be unpublished', function () {
    actingAs(UserFactory::new()->create());
    $post = Post::factory()->published()->create();
    expect($post->published_at)->not->toBeNull();

    postJson("/admin/posts/{$post->id}/unpublish")->assertStatus(200);
    expect(Post::query()->withNotPublished()->find($post->id)->published_at)
        ->toBeNull();
});
