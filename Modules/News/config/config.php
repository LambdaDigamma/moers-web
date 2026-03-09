<?php

return [

    'feed_model' => \Modules\News\Models\Feed::class,

    'post_model' => \Modules\News\Models\Post::class,

    /**
     * The api endpoints are being registered
     * under this prefix.
     */
    'api_prefix' => 'api',

    /**
     * This middleware stack is being
     * used for all api routes.
     */
    'api_middleware' => ['api'],

    /**
     * The admin endpoints are being registered
     * under this prefix.
     */
    'admin_prefix' => 'admin',

    /**
     * This middleware stack is being
     * used for all api routes.
     */
    'admin_middleware' => ['web', 'auth'],

    'rss_sources' => [
        [
            'key' => 'rheinische-post',
            'name' => 'Rheinische Post',
            'url' => 'https://rp-online.de/nrw/staedte/moers/feed.rss',
        ],
        [
            'key' => 'lokalkompass',
            'name' => 'Lokalkompass',
            'url' => 'https://www.lokalkompass.de/moers/rss',
        ],
        [
            'key' => 'nrz',
            'name' => 'NRZ',
            'url' => 'https://www.nrz.de/?config=rss_moers_app',
        ],
    ],

    'rss_import_cron' => '15 * * * *',

];
