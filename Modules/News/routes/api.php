<?php

use Illuminate\Support\Facades\Route;
use Modules\News\Http\Controllers\API\FeedController;
use Modules\News\Http\Controllers\API\FeedPostsController;
use Modules\News\Http\Controllers\API\PostController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::group([
    'prefix' => 'v1/',
    'as' => 'v1.'
], function () {

    Route::get('/feeds/{id}', [FeedController::class, 'show'])
        ->middleware('cache.headers:public;max_age=300;etag')
        ->name('feeds.show');

    Route::get('/feeds/{id}/posts', [FeedPostsController::class, 'index'])
        ->middleware('cache.headers:public;max_age=300;etag')
        ->name('feeds.posts.index');

    Route::get('/posts/{id}', [PostController::class, 'show'])
        ->middleware('cache.headers:public;max_age=300;etag')
        ->name('posts.show');

});
