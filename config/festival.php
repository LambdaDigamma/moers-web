<?php

$festivalNewsFeedId = env('FESTIVAL_NEWS_FEED_ID');

return [
    'current_collection' => env('FESTIVAL_CURRENT_COLLECTION', 'moers-festival-'.date('Y')),

    'feed_aliases' => [
        3 => (int) env('FESTIVAL_NEWS_FEED_ID', 3),
    ],

    'news' => [
        'source_feed_id' => is_numeric($festivalNewsFeedId) ? (int) $festivalNewsFeedId : null,
        'page_slug_sections' => ['n', 'news', 'neuigkeiten'],
    ],

    'pagination' => [
        'events' => 400,
        'content' => 200,
        'feed_posts' => 10,
    ],

    'stream' => [
        'url' => env('FESTIVAL_STREAM_URL'),
        'start_date' => env('FESTIVAL_STREAM_START_DATE'),
        'failure_title' => env('FESTIVAL_STREAM_FAILURE_TITLE', 'Kein aktiver Livestream'),
        'failure_description' => env(
            'FESTIVAL_STREAM_FAILURE_DESCRIPTION',
            'Momentan läuft kein Livestream. Komme bald wieder, um Dir den Livestream anzusehen.'
        ),
    ],
];
