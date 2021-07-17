<?php

return [

    'page_model' => LambdaDigamma\MMPages\Models\Page::class,

    'page_block_model' => LambdaDigamma\MMPages\Models\PageBlock::class,

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

    'admin_middleware_stateless' => ['api', 'auth'],

];
