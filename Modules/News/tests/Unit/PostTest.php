<?php

use Modules\News\Models\Feed;
use Modules\News\Models\Post;

test('post can be created', function () {
    $post = Post::factory()->create([
        'title' => 'Post #1',
        'summary' => 'This is a short summary.',
        'slug' => 'post-1',
    ]);

    expect($post->title)->toBe('Post #1')
        ->and($post->summary)->toBe('This is a short summary.')
        ->and($post->slug)->toBe('post-1');
});

test('post can have localized title, summary, slug', function () {
    app()->setLocale('en');

    $post = Post::factory()->create([
        'title' => 'Post #1',
        'summary' => 'Short summary',
        'slug' => 'post-1',
        'external_href' => 'https://example.com',
    ]);

    $post->setTranslation('title', 'de', 'Eintrag #1');
    $post->setTranslation('summary', 'de', 'Kurze Zusammenfassung');
    $post->setTranslation('slug', 'de', 'eintrag-1');
    $post->setTranslation('external_href', 'de', 'https://example.de');

    expect($post->getTranslation('title', 'en'))->toBe('Post #1')
        ->and($post->getTranslation('title', 'de'))->toBe('Eintrag #1');

    expect($post->getTranslation('summary', 'en'))->toBe('Short summary')
        ->and($post->getTranslation('summary', 'de'))->toBe('Kurze Zusammenfassung');

    expect($post->getTranslation('slug', 'en'))->toBe('post-1')
        ->and($post->getTranslation('slug', 'de'))->toBe('eintrag-1');

    expect($post->getTranslation('external_href', 'en'))->toBe('https://example.com')
        ->and($post->getTranslation('external_href', 'de'))->toBe('https://example.de');
});

test('post can belong to feed', function () {
    $post = Post::factory()->create();
    $feed = Feed::factory()->create();

    $feed->posts()->save($post);

    expect($post->feeds->pluck('id'))->toContain($feed->id);
});

test('post can be published', function () {
    $post = Post::factory()->create();

    expect($post->published_at)->toBeNull();

    $post->publish();

    expect($post->published_at)->not->toBeNull();
});

test('post can be unpublished', function () {
    $post = Post::factory()->published()->create();

    expect($post->published_at)->not->toBeNull();

    $post->unpublish();

    expect($post->published_at)->toBeNull();
});

test('post can have a cta attribute', function () {
    $post = Post::factory()->published()->create(['extras' => ['cta' => 'watch']]);
    expect($post->cta)->toBe('watch');
});

test('post can set a cta attribute', function () {
    $post = Post::factory()->published()->create();
    $post->cta = 'watch';
    expect($post->cta)->toBe('watch');
    $post->cta = 'more';
    expect($post->cta)->toBe('more');
});
