<?php

use Illuminate\Support\Facades\Route;
use Modules\News\Http\Controllers\Admin\PostActionController;
use Modules\News\Http\Controllers\Admin\PostController;
use Modules\News\Http\Controllers\Admin\PublishedPostsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'auth'],
    'as' => 'admin.',
], function () {

    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    Route::post('/posts/{anypost}/publish', [PublishedPostsController::class, 'publish'])->name('posts.publish');
    Route::post('/posts/{anypost}/unpublish', [PublishedPostsController::class, 'unpublish'])->name('posts.unpublish');

    Route::post('/posts/{anypost}/archive', [PostActionController::class, 'archive'])->name('posts.archive');
    Route::post('/posts/{anypost}/unarchive', [PostActionController::class, 'unarchive'])->name('posts.unarchive');

});
