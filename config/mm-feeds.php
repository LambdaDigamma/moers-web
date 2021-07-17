<?php

return [

    'feed_model' => LambdaDigamma\MMFeeds\Models\Feed::class,

    'post_model' => LambdaDigamma\MMFeeds\Models\Post::class,

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

];
