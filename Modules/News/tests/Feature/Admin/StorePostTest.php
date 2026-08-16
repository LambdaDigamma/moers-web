<?php

use App\Models\Page;
use App\Models\PageBlock;
use Database\Factories\UserFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Modules\News\Models\Feed;
use Modules\News\Models\Post;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\getJson;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

beforeEach(function () {
    Storage::fake('media');
});

test('authenticated non admins cannot access post management routes', function () {
    $post = Post::factory()->create();

    actingAs(UserFactory::new()->create());

    get(route('posts.index'))->assertForbidden();
    get(route('posts.create'))->assertForbidden();
    get(route('posts.edit', $post))->assertForbidden();
    post(route('posts.store'))->assertForbidden();
    put(route('posts.update', $post))->assertForbidden();
    post(route('posts.publish', $post))->assertForbidden();
    post(route('posts.unpublish', $post))->assertForbidden();
    post(route('posts.archive', $post))->assertForbidden();
    post(route('posts.unarchive', $post))->assertForbidden();
});

test('admin users can store posts with feeds and tiptap content', function () {
    app()->setLocale('de');

    $feeds = Feed::factory()
        ->count(2)
        ->sequence(
            ['name' => ['de' => 'Rathaus'], 'identifier' => 'rathaus'],
            ['name' => ['de' => 'Kultur'], 'identifier' => 'kultur'],
        )
        ->create();

    $document = [
        'type' => 'doc',
        'content' => [
            [
                'type' => 'paragraph',
                'content' => [
                    [
                        'type' => 'text',
                        'text' => 'Der neue Beitragstext.',
                    ],
                ],
            ],
        ],
    ];

    actingAs(UserFactory::new()->admin()->create());

    post(route('posts.store'), [
        'title' => 'Neue Baustelle',
        'summary' => 'Die Arbeiten beginnen am Montag.',
        'external_href' => 'https://example.com/baustelle',
        'slug' => 'neue-baustelle',
        'feed_ids' => $feeds->pluck('id')->all(),
        'content' => $document,
        'header_image' => UploadedFile::fake()->image('header.jpg'),
    ])->assertRedirect();

    $post = Post::query()
        ->withNotPublished()
        ->with('feeds')
        ->sole();

    expect($post->title)->toBe('Neue Baustelle')
        ->and($post->summary)->toBe('Die Arbeiten beginnen am Montag.')
        ->and($post->external_href)->toBe('https://example.com/baustelle')
        ->and($post->slug)->toBe('neue-baustelle')
        ->and($post->feeds->pluck('id')->sort()->values()->all())->toBe($feeds->pluck('id')->sort()->values()->all())
        ->and($post->getMedia('header'))->toHaveCount(1)
        ->and($post->getFirstMedia('header')?->file_name)->toBe('header.jpg');

    $page = Page::query()
        ->withNotPublished()
        ->withArchived()
        ->findOrFail($post->page_id);
    $bodyBlocks = $page->blocks()
        ->withNotPublished()
        ->where('type', 'tiptap-text')
        ->get();

    expect($page->title)->toBe('Neue Baustelle')
        ->and($page->summary)->toBe('Die Arbeiten beginnen am Montag.')
        ->and($page->slug)->toBe('news/neue-baustelle')
        ->and($bodyBlocks)->toHaveCount(1);

    $bodyBlock = $bodyBlocks->sole();
    $data = $bodyBlock->getTranslation('data', 'de', false);

    expect($bodyBlock->type)->toBe('tiptap-text')
        ->and($data)->toHaveKey('text')
        ->and($data['text'])->toBe($document);

    getJson(route('festival.v1.pages.show', $post->page_id))
        ->assertNotFound();

    post(route('posts.publish', $post))->assertRedirect();

    getJson(route('festival.v1.pages.show', $post->page_id))
        ->assertSuccessful()
        ->assertJsonPath('data.id', $post->page_id)
        ->assertJsonPath('data.blocks.0.type', 'tiptap-text');
});

test('admin users can update posts without replacing unrelated page blocks', function () {
    app()->setLocale('de');

    $oldFeed = Feed::factory()->create(['name' => ['de' => 'Alt'], 'identifier' => 'alt']);
    $newFeed = Feed::factory()->create(['name' => ['de' => 'Neu'], 'identifier' => 'neu']);
    $page = Page::factory()->create([
        'title' => ['de' => 'Alter Titel'],
        'summary' => ['de' => 'Alter Auszug'],
        'slug' => ['de' => 'news/alter-titel'],
        'published_at' => now(),
    ]);
    $post = Post::factory()->create([
        'title' => ['de' => 'Alter Titel'],
        'summary' => ['de' => 'Alter Auszug'],
        'slug' => ['de' => 'alter-titel'],
        'external_href' => ['de' => 'https://example.com/alt'],
        'page_id' => $page->id,
    ]);

    $post->feeds()->attach($oldFeed, ['order' => 7]);

    $oldDocument = [
        'type' => 'doc',
        'content' => [
            [
                'type' => 'paragraph',
                'content' => [
                    ['type' => 'text', 'text' => 'Alter Text.'],
                ],
            ],
        ],
    ];
    $newDocument = [
        'type' => 'doc',
        'content' => [
            [
                'type' => 'paragraph',
                'content' => [
                    ['type' => 'text', 'text' => 'Aktualisierter Text.'],
                ],
            ],
        ],
    ];

    $unrelatedBlock = PageBlock::factory()->for($page)->create([
        'type' => 'hero',
        'order' => 0,
        'data' => ['de' => ['headline' => 'Bleibt bestehen']],
        'published_at' => now(),
    ]);
    $legacyBodyBlock = PageBlock::factory()->for($page)->create([
        'type' => 'tip-tap-text',
        'order' => 1,
        'data' => ['de' => ['text' => $oldDocument, 'style' => 'intro']],
        'published_at' => now(),
    ]);

    actingAs(UserFactory::new()->admin()->create());

    put(route('posts.update', $post), [
        'title' => 'Aktualisierter Titel',
        'summary' => 'Aktualisierter Auszug',
        'external_href' => 'https://example.com/neu',
        'slug' => 'aktualisierter-titel',
        'feed_ids' => [$newFeed->id],
        'content' => $newDocument,
    ])->assertRedirect();

    $post->refresh()->load(['feeds', 'page']);
    $legacyBodyBlock->refresh();
    $unrelatedBlock->refresh();
    $legacyBodyData = $legacyBodyBlock->getTranslation('data', 'de', false);

    expect($post->title)->toBe('Aktualisierter Titel')
        ->and($post->summary)->toBe('Aktualisierter Auszug')
        ->and($post->external_href)->toBe('https://example.com/neu')
        ->and($post->slug)->toBe('aktualisierter-titel')
        ->and($post->feeds->pluck('id')->all())->toBe([$newFeed->id])
        ->and($post->page_id)->toBe($page->id)
        ->and($legacyBodyBlock->type)->toBe('tip-tap-text')
        ->and($legacyBodyData['text'])->toBe($newDocument)
        ->and($legacyBodyData['style'])->toBe('intro')
        ->and($unrelatedBlock->type)->toBe('hero')
        ->and($unrelatedBlock->getTranslation('data', 'de', false))->toBe(['headline' => 'Bleibt bestehen']);

    expect(PageBlock::query()->withNotPublished()->where('page_id', $page->id)->count())->toBe(2)
        ->and(PageBlock::query()->withNotPublished()->where('page_id', $page->id)->whereIn('type', ['tiptap-text', 'tip-tap-text'])->count())->toBe(1)
        ->and(PageBlock::query()->withNotPublished()->whereKey($legacyBodyBlock->id)->exists())->toBeTrue()
        ->and(PageBlock::query()->withNotPublished()->whereKey($unrelatedBlock->id)->exists())->toBeTrue();
});

test('admin users can edit draft posts with draft page content', function () {
    app()->setLocale('de');

    $document = [
        'type' => 'doc',
        'content' => [
            [
                'type' => 'paragraph',
                'content' => [
                    ['type' => 'text', 'text' => 'Entwurfstext.'],
                ],
            ],
        ],
    ];
    $page = Page::factory()->notPublished()->create();
    PageBlock::factory()->for($page)->create([
        'type' => 'tiptap-text',
        'data' => ['de' => ['text' => $document]],
    ]);
    $post = Post::factory()->notPublished()->create(['page_id' => $page->id]);

    actingAs(UserFactory::new()->admin()->create());

    get(route('posts.edit', $post))
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('posts/edit-post')
            ->where('initialContent', $document));
});
