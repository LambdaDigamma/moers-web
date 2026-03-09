<?php

use Illuminate\Support\Facades\Http;
use Modules\News\Models\Feed;
use Modules\News\Models\Post;

it('imports external rss posts and updates existing entries', function () {
    config()->set('news.rss_sources', [
        [
            'key' => 'rheinische-post',
            'name' => 'Rheinische Post',
            'url' => 'https://example.test/rp.rss',
        ],
        [
            'key' => 'lokalkompass',
            'name' => 'Lokalkompass',
            'url' => 'https://example.test/lokalkompass.rss',
        ],
        [
            'key' => 'nrz',
            'name' => 'NRZ',
            'url' => 'https://example.test/nrz.rss',
        ],
    ]);

    Http::fake([
        'https://example.test/rp.rss' => Http::response(<<<'XML'
            <rss version="2.0">
                <channel>
                    <title>Rheinische Post</title>
                    <item>
                        <title>Moers bekommt neue Fahrradstation</title>
                        <link>https://rp.example.test/fahrradstation</link>
                        <guid>rp-1</guid>
                        <description><![CDATA[<p>Die neue Station startet im April.</p>]]></description>
                        <pubDate>Mon, 10 Mar 2025 08:00:00 +0100</pubDate>
                    </item>
                    <item>
                        <title>Neues Kulturprojekt startet</title>
                        <link>https://rp.example.test/kulturprojekt</link>
                        <guid>rp-2</guid>
                        <description><![CDATA[<p>Das Projekt wird im Sommer eröffnet.</p>]]></description>
                        <pubDate>Mon, 10 Mar 2025 12:00:00 +0100</pubDate>
                    </item>
                </channel>
            </rss>
            XML),
        'https://example.test/lokalkompass.rss' => Http::response(<<<'XML'
            <rss version="2.0">
                <channel>
                    <title>Lokalkompass</title>
                    <item>
                        <title>Stadtteilfest in Repelen geplant</title>
                        <link>https://lokalkompass.example.test/stadtteilfest</link>
                        <guid>lk-1</guid>
                        <description><![CDATA[<div>Das Fest findet am Wochenende statt.</div>]]></description>
                        <pubDate>Tue, 11 Mar 2025 09:30:00 +0100</pubDate>
                    </item>
                </channel>
            </rss>
            XML),
        'https://example.test/nrz.rss' => Http::response(<<<'XML'
            <rss version="2.0">
                <channel>
                    <title>NRZ</title>
                    <item>
                        <title>Neuer Spielplatz eröffnet</title>
                        <link>https://nrz.example.test/spielplatz</link>
                        <guid>nrz-1</guid>
                        <description><![CDATA[<p>Ein neuer Treffpunkt für Familien.</p>]]></description>
                        <pubDate>Wed, 12 Mar 2025 11:00:00 +0100</pubDate>
                    </item>
                </channel>
            </rss>
            XML, 404),
    ]);

    $this->artisan('posts:import-external')
        ->expectsOutput('Importing external posts...')
        ->assertExitCode(0);

    expect(Post::query()->count())->toBe(4)
        ->and(Feed::query()->count())->toBe(3);

    $post = Post::query()->firstWhere('external_href', 'https://rp.example.test/fahrradstation');

    expect($post)->not->toBeNull()
        ->and($post->title)->toBe('Moers bekommt neue Fahrradstation')
        ->and($post->summary)->toBe('Die neue Station startet im April.')
        ->and($post->published_at?->toIso8601String())->not->toBeNull()
        ->and($post->extras?->get('rss_source_key'))->toBe('rheinische-post')
        ->and($post->feeds->pluck('name')->all())->toBe(['Rheinische Post']);

    Http::fake([
        'https://example.test/rp.rss' => Http::response(<<<'XML'
            <rss version="2.0">
                <channel>
                    <title>Rheinische Post</title>
                    <item>
                        <title>Moers bekommt neue Fahrradstation</title>
                        <link>https://rp.example.test/fahrradstation</link>
                        <guid>rp-1</guid>
                        <description><![CDATA[<p>Die Station startet bereits im März.</p>]]></description>
                        <pubDate>Mon, 10 Mar 2025 08:00:00 +0100</pubDate>
                    </item>
                </channel>
            </rss>
            XML),
        'https://example.test/lokalkompass.rss' => Http::response('<rss version="2.0"><channel><title>Lokalkompass</title></channel></rss>'),
        'https://example.test/nrz.rss' => Http::response('<rss version="2.0"><channel><title>NRZ</title></channel></rss>'),
    ]);

    $this->artisan('posts:import-external')->assertExitCode(0);

    expect(Post::query()->count())->toBe(4)
        ->and(Feed::query()->count())->toBe(3)
        ->and($post->fresh()->summary)->toBe('Die Station startet bereits im März.');
});

it('extracts an image url from rss-specific fields', function () {
    $command = app(\Modules\News\Console\Commands\ImportExternalPostsCommand::class);
    $method = new \ReflectionMethod($command, 'resolveImageUrl');
    $method->setAccessible(true);

    $item = new \SimpleXMLElement(<<<'XML'
        <item xmlns:media="http://search.yahoo.com/mrss/">
            <title>Bildbeitrag</title>
            <description><![CDATA[<p>Beschreibung <img src="https://example.test/fallback.jpg" /></p>]]></description>
            <media:content url="https://example.test/media.jpg" />
        </item>
        XML);

    expect($method->invoke($command, $item))->toBe('https://example.test/media.jpg');
});

it('extracts rp image urls from the gera namespace', function () {
    $command = app(\Modules\News\Console\Commands\ImportExternalPostsCommand::class);
    $method = new \ReflectionMethod($command, 'resolveImageUrl');
    $method->setAccessible(true);

    $item = new \SimpleXMLElement(<<<'XML'
        <item xmlns:gera="http://rp-online/rss/namespace">
            <title>RP Beitrag</title>
            <gera:imageUrl>https://example.test/gera.jpg</gera:imageUrl>
        </item>
        XML);

    expect($method->invoke($command, $item))->toBe('https://example.test/gera.jpg');
});
