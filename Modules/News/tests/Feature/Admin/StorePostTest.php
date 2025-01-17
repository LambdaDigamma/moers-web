<?php

namespace LambdaDigamma\MMFeeds\Tests\Feature\Admin;

use Database\Factories\UserFactory;
use Modules\News\Models\Post;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;
use function Pest\Laravel\postJson;

test('authenticated user can store post via form (POST /admin/posts)', function () {
    expect(Post::all())->toHaveCount(0);
    actingAs(UserFactory::new()->create());

    post(route('admin.posts.store'), [
        'title' => 'Title of the post',
        'summary' => 'This is a short summary',
    ])->assertStatus(302);

    $post = Post::withNotPublished()->first();

    expect($post->title)->toBe('Title of the post');
    expect($post->summary)->toBe('This is a short summary');
});

test('store post via json (POST /admin/posts)', function () {
    expect(Post::all())->toHaveCount(0);
    actingAs(UserFactory::new()->create());

    postJson(route('admin.posts.store'), [
        'title' => 'Title of the post',
        'summary' => 'This is a short summary',
    ])
    ->assertStatus(302)
    ->assertJson([
        'title' => 'Title of the post',
        'summary' => 'This is a short summary',
    ]);

    $post = Post::withNotPublished()->first();

    expect($post->title)->toBe('Title of the post');
    expect($post->summary)->toBe('This is a short summary');
});
