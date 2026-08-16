<?php

use App\Models\Page;
use Illuminate\Support\Facades\File;
use Modules\Events\Models\Event;
use Modules\News\Models\Post;

it('only includes public routable records in the generated sitemap', function () {
    $sitemapPath = public_path('sitemap.xml');
    $originalSitemap = File::exists($sitemapPath) ? File::get($sitemapPath) : null;

    try {
        $page = Page::factory()->published()->create([
            'title' => ['de' => 'Alte Festival-Seite'],
            'slug' => ['de' => 'moers-festival-202526/e/alte-festival-seite'],
        ]);
        $publishedPost = Post::factory()->published()->create();
        $draftPost = Post::factory()->notPublished()->create();
        $currentEvent = Event::factory()->published()->create([
            'start_date' => now()->addDay(),
            'extras' => ['collection' => config('festival.current_collection')],
        ]);
        $draftEvent = Event::factory()->notPublished()->create();

        $this->artisan('sitemap:generate')->assertSuccessful();

        $sitemap = File::get($sitemapPath);

        expect($sitemap)
            ->toContain(route('news.show', $publishedPost->id))
            ->not->toContain(route('news.show', $draftPost->id))
            ->toContain(route('events.show', $currentEvent->id))
            ->not->toContain(url('/de/moers-festival-202526/e/alte-festival-seite'))
            ->not->toContain(route('events.show', $draftEvent->id));
    } finally {
        if ($originalSitemap === null) {
            File::delete($sitemapPath);
        } else {
            File::put($sitemapPath, $originalSitemap);
        }
    }
});
