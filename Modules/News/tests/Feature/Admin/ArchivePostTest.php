<?php

use App\Models\Page;
use App\Models\PageBlock;
use Database\Factories\UserFactory;
use Modules\News\Models\Post;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

test('post can be archived', function () {
    actingAs(UserFactory::new()->admin()->create());
    $page = Page::factory()->published()->create();
    PageBlock::factory()
        ->published()
        ->for($page)
        ->create([
            'type' => 'tiptap-text',
        ]);
    $post = Post::factory()->published()->create(['page_id' => $page->id]);
    expect($post->archived_at)->toBeNull();

    postJson("/admin/posts/{$post->id}/archive")->assertStatus(200);
    expect(Post::query()->withNotPublished()->withArchived()->find($post->id)->archived_at)
        ->not->toBeNull()
        ->and($page->refresh()->archived_at)
        ->not->toBeNull();

    getJson(route('festival.v1.pages.show', $page))->assertNotFound();
});

test('not published post can be archived', function () {
    actingAs(UserFactory::new()->admin()->create());
    $post = Post::factory()->create();
    expect($post->archived_at)->toBeNull();

    postJson("/admin/posts/{$post->id}/archive")->assertStatus(200);
    expect(Post::query()->withNotPublished()->withArchived()->find($post->id)->archived_at)
        ->not->toBeNull();
});

test('archived post can be unarchived', function () {
    actingAs(UserFactory::new()->admin()->create());
    $page = Page::factory()->published()->archived()->create();
    PageBlock::factory()
        ->published()
        ->for($page)
        ->create([
            'type' => 'tiptap-text',
        ]);
    $post = Post::factory()->published()->archived()->create(['page_id' => $page->id]);
    expect($post->archived_at)->not->toBeNull();

    postJson("/admin/posts/{$post->id}/unarchive")->assertStatus(200);
    expect(Post::query()->withNotPublished()->withArchived()->find($post->id)->archived_at)
        ->toBeNull()
        ->and($page->refresh()->archived_at)
        ->toBeNull();

    getJson(route('festival.v1.pages.show', $page))->assertSuccessful();
});

test('archived not published post can be unarchived', function () {
    actingAs(UserFactory::new()->admin()->create());
    $post = Post::factory()->archived()->create();

    expect($post->archived_at)->not->toBeNull();

    postJson("/admin/posts/{$post->id}/unarchive")->assertStatus(200);
    expect(Post::query()->withNotPublished()->withArchived()->find($post->id)->archived_at)->toBeNull();
});
