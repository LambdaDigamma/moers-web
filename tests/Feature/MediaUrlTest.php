<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\News\Models\Post;

use function Pest\Laravel\get;

beforeEach(function () {
    config()->set('media-library.disk_name', 'media');
    Storage::fake('media');
});

it('does not expose URLs for deleted media files', function () {
    $post = Post::factory()->published()->create([
        'title' => 'Nachricht mit fehlendem Bild',
    ]);
    $media = $post
        ->addMedia(UploadedFile::fake()->image('header.jpg'))
        ->toMediaCollection('header');

    expect($post->fresh()->getFirstMediaUrl('header'))->not->toBe('');

    Storage::disk($media->disk)->delete($media->getPathRelativeToRoot());

    expect($post->fresh()->getFirstMediaUrl('header'))->toBe('');
    expect(data_get($post->fresh()->toArray(), 'media_collections.header'))->toBeNull();

    get('/news')
        ->assertInertia(fn ($page) => $page
            ->where('posts.data.0.header_image_url', null));

    get('/')
        ->assertInertia(fn ($page) => $page
            ->where('latestNews.0.header_image_url', null));
});
