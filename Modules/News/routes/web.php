<?php

use Illuminate\Support\Facades\Route;
use Modules\News\Http\Controllers\Admin\PostActionController;
use Modules\News\Http\Controllers\Admin\PostController as AdminPostController;
use Modules\News\Http\Controllers\Admin\PublishedPostsController;
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
    'middleware' => ['web', 'auth'],
], function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::post('/posts/{anypost}/publish', [PublishedPostsController::class, 'publish'])->name('posts.publish');
    Route::post('/posts/{anypost}/unpublish', [PublishedPostsController::class, 'unpublish'])->name('posts.unpublish');
    Route::post('/posts/{anypost}/archive', [PostActionController::class, 'archive'])->name('posts.archive');
    Route::post('/posts/{anypost}/unarchive', [PostActionController::class, 'unarchive'])->name('posts.unarchive');
});

Route::group([
    'prefix' => 'admin',
    'middleware' => ['web', 'auth'],
    'as' => 'admin.',
], function () {

    Route::post('/posts', [AdminPostController::class, 'store'])->name('posts.store');

    Route::post('/posts/{anypost}/publish', [PublishedPostsController::class, 'publish'])->name('posts.publish');
    Route::post('/posts/{anypost}/unpublish', [PublishedPostsController::class, 'unpublish'])->name('posts.unpublish');

    Route::post('/posts/{anypost}/archive', [PostActionController::class, 'archive'])->name('posts.archive');
    Route::post('/posts/{anypost}/unarchive', [PostActionController::class, 'unarchive'])->name('posts.unarchive');

});
