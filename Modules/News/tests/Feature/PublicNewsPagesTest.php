<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Modules\News\Models\Feed;
use Modules\News\Models\Post;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('shows published news on the public index', function () {
    $post = Post::factory()->published()->create([
        'title' => 'Stadtfest startet',
        'summary' => 'Am Wochenende beginnt das Stadtfest.',
        'external_href' => 'https://example.com/stadtfest',
    ]);
    $feed = Feed::factory()->create([
        'name' => 'Rheinische Post',
    ]);
    $feed->posts()->attach($post, ['order' => 0]);

    Post::factory()->notPublished()->create([
        'title' => 'Nur intern',
    ]);

    get('/news')
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('news/index')
            ->has('posts.data', 1)
            ->where('posts.data.0.title', 'Stadtfest startet')
            ->where('posts.data.0.external_href', 'https://example.com/stadtfest')
            ->where('posts.data.0.header_image_url', null)
            ->where('posts.data.0.source_name', 'Rheinische Post'));
});

it('shows a public news detail page for published posts', function () {
    $post = Post::factory()->published()->create([
        'title' => 'Neuer Wochenmarkt',
        'summary' => 'Der Wochenmarkt findet ab sofort mittwochs statt.',
    ]);

    get("/news/{$post->id}")
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('news/show')
            ->where('post.title', 'Neuer Wochenmarkt')
            ->where('post.summary', 'Der Wochenmarkt findet ab sofort mittwochs statt.'));
});

it('does not expose unpublished news publicly', function () {
    $post = Post::factory()->notPublished()->create();

    get("/news/{$post->id}")
        ->assertNotFound();
});

it('shows unpublished news to signed in users on the same listing', function () {
    Post::factory()->published()->create([
        'title' => 'Oeffentlich',
    ]);
    Post::factory()->notPublished()->create([
        'title' => 'Entwurf',
    ]);

    actingAs(User::factory()->create());

    get('/news')
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('news/index')
            ->has('posts.data', 2));
});

it('shows unpublished news details to signed in users on the same route', function () {
    $post = Post::factory()->notPublished()->create([
        'title' => 'Interner Entwurf',
    ]);

    actingAs(User::factory()->create());

    get("/news/{$post->id}")
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('news/show')
            ->where('post.title', 'Interner Entwurf')
            ->where('post.canManage', true));
});
