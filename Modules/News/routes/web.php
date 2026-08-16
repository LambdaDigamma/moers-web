<?php

use Illuminate\Support\Facades\Route;
use Modules\News\Http\Controllers\Admin\PostActionController;
use Modules\News\Http\Controllers\Admin\PostController as AdminPostController;
use Modules\News\Http\Controllers\Admin\PublishedPostsController;
use Modules\News\Http\Controllers\FeedController;
use Modules\News\Http\Controllers\PostController;

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

Route::get('/news', [PostController::class, 'index'])->name('news.index');
Route::get('/news/{anypost}', [PostController::class, 'show'])->name('news.show');

Route::group([
    'middleware' => ['web', 'auth', 'admin.access'],
], function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/{anypost}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('/posts/{anypost}', [PostController::class, 'update'])->name('posts.update');
    Route::post('/posts/{anypost}/publish', [PublishedPostsController::class, 'publish'])->name('posts.publish');
    Route::post('/posts/{anypost}/unpublish', [PublishedPostsController::class, 'unpublish'])->name('posts.unpublish');
    Route::post('/posts/{anypost}/archive', [PostActionController::class, 'archive'])->name('posts.archive');
    Route::post('/posts/{anypost}/unarchive', [PostActionController::class, 'unarchive'])->name('posts.unarchive');

    Route::get('/feeds', [FeedController::class, 'index'])->name('feeds.index');
    Route::get('/feeds/create', [FeedController::class, 'create'])->name('feeds.create');
    Route::post('/feeds', [FeedController::class, 'store'])->name('feeds.store');
    Route::get('/feeds/{anyfeed}/edit', [FeedController::class, 'edit'])->name('feeds.edit');
    Route::put('/feeds/{anyfeed}', [FeedController::class, 'update'])->name('feeds.update');
    Route::delete('/feeds/{anyfeed}', [FeedController::class, 'destroy'])->name('feeds.destroy');
    Route::post('/feeds/{anyfeed}/restore', [FeedController::class, 'restore'])->name('feeds.restore');
});

Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'auth', 'admin.access'],
    'as' => 'admin.',
], function () {

    Route::post('/posts', [AdminPostController::class, 'store'])->name('posts.store');

    Route::post('/posts/{anypost}/publish', [PublishedPostsController::class, 'publish'])->name('posts.publish');
    Route::post('/posts/{anypost}/unpublish', [PublishedPostsController::class, 'unpublish'])->name('posts.unpublish');

    Route::post('/posts/{anypost}/archive', [PostActionController::class, 'archive'])->name('posts.archive');
    Route::post('/posts/{anypost}/unarchive', [PostActionController::class, 'unarchive'])->name('posts.unarchive');

});
