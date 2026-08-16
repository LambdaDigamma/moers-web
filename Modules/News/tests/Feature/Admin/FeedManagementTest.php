<?php

use Database\Factories\UserFactory;
use Modules\News\Models\Feed;
use Modules\News\Models\Post;
use Modules\News\Models\Publication;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('authenticated non admins cannot access feed management routes', function () {
    $feed = Feed::factory()->create(['identifier' => 'stadt']);

    actingAs(UserFactory::new()->create());

    get(route('feeds.index'))->assertForbidden();
    get(route('feeds.create'))->assertForbidden();
    get(route('feeds.edit', $feed))->assertForbidden();
    post(route('feeds.store'))->assertForbidden();
    put(route('feeds.update', $feed))->assertForbidden();
    delete(route('feeds.destroy', $feed))->assertForbidden();

    $feed->delete();

    post(route('feeds.restore', $feed))->assertForbidden();
});

test('admin users can create update soft delete and restore feeds', function () {
    app()->setLocale('de');

    actingAs(UserFactory::new()->admin()->create());

    post(route('feeds.store'), [
        'name' => 'Stadtmeldungen',
        'identifier' => 'stadtmeldungen',
    ])->assertRedirect();

    $feed = Feed::query()->sole();

    expect($feed->name)->toBe('Stadtmeldungen')
        ->and($feed->identifier)->toBe('stadtmeldungen');

    put(route('feeds.update', $feed), [
        'name' => 'Aktuelle Stadtmeldungen',
        'identifier' => 'anderer-identifier',
    ])->assertRedirect();

    $feed->refresh();

    expect($feed->name)->toBe('Aktuelle Stadtmeldungen')
        ->and($feed->identifier)->toBe('stadtmeldungen');

    delete(route('feeds.destroy', $feed))->assertRedirect(route('feeds.index'));

    expect($feed->refresh()->deleted_at)->not->toBeNull();

    post(route('feeds.restore', $feed))->assertRedirect();

    expect($feed->refresh()->deleted_at)->toBeNull()
        ->and($feed->identifier)->toBe('stadtmeldungen');
});

test('admin users can attach detach and reorder feed posts without duplicate publications', function () {
    app()->setLocale('de');

    $feed = Feed::factory()->create(['name' => ['de' => 'Stadtmeldungen'], 'identifier' => 'stadtmeldungen']);
    $posts = Post::factory()
        ->count(3)
        ->sequence(
            ['title' => ['de' => 'Erste Meldung']],
            ['title' => ['de' => 'Zweite Meldung']],
            ['title' => ['de' => 'Dritte Meldung']],
        )
        ->create();

    actingAs(UserFactory::new()->admin()->create());

    put(route('feeds.update', $feed), [
        'name' => 'Stadtmeldungen',
        'posts' => [
            ['id' => $posts[0]->id, 'order' => 2],
            ['id' => $posts[1]->id, 'order' => 0],
            ['id' => $posts[1]->id, 'order' => 1],
        ],
    ])->assertRedirect();

    expect(Publication::query()->where('feed_id', $feed->id)->count())->toBe(2)
        ->and(Publication::query()->where('feed_id', $feed->id)->where('post_id', $posts[0]->id)->value('order'))->toBe(2)
        ->and(Publication::query()->where('feed_id', $feed->id)->where('post_id', $posts[1]->id)->value('order'))->toBe(0);

    put(route('feeds.update', $feed), [
        'name' => 'Stadtmeldungen',
        'posts' => [
            ['id' => $posts[1]->id, 'order' => 4],
            ['id' => $posts[2]->id, 'order' => 1],
            ['id' => $posts[2]->id, 'order' => 9],
        ],
    ])->assertRedirect();

    expect(Publication::query()->where('feed_id', $feed->id)->count())->toBe(2)
        ->and(Publication::query()->where('feed_id', $feed->id)->where('post_id', $posts[0]->id)->exists())->toBeFalse()
        ->and(Publication::query()->where('feed_id', $feed->id)->where('post_id', $posts[1]->id)->value('order'))->toBe(4)
        ->and(Publication::query()->where('feed_id', $feed->id)->where('post_id', $posts[2]->id)->value('order'))->toBe(1);
});
