<?php

use App\Http\Controllers\FestivalCompatController;
use App\Http\Controllers\TrackerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Events\Http\Controllers\API\OrganisationEventsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group([
    'middleware' => ['api'],
    'prefix' => 'v1/',
], function () {

    Route::group(['middleware' => 'cache.headers:public;max_age=0;must_revalidate;etag'], function () {
        Route::get('organisations/{organisation:slug}/events', [OrganisationEventsController::class, 'index']);
    });

    //        Route::get('events/{event:slug}', [OrganisationEventsController::class, 'show']);

    //    Route::get('/v1/organisations/{organisation:slug}/events/{event:slug}/bulk-download');
    //    Route::get('/v1/organisations/{organisation:slug}/posts');

    // Should also return the events at the location (used for the map of the events)
    //    Route::get('/v1/organisations/{organisation:slug}/events/{event:slug}/locations');
    //    Route::get('/v1/locations/{location:slug}');

    //    Route::get('/v1/posts/{post:id}');
    //    Route::get('/v1/pages/{page:id}');

});

Route::group([
    'middleware' => ['api'],
    'prefix' => 'v1/festival',
    'as' => 'festival.v1.',
], function () {
    Route::get('events', [FestivalCompatController::class, 'eventsIndex'])
        ->middleware('cache.headers:public;max_age=0;must_revalidate;etag')
        ->name('events.index');

    Route::get('events/{id}', [FestivalCompatController::class, 'eventsShow'])
        ->middleware('cache.headers:public;max_age=0;must_revalidate;etag')
        ->name('events.show');

    Route::get('festival/content', [FestivalCompatController::class, 'festivalContent'])
        ->middleware('cache.headers:public;max_age=600;etag')
        ->name('festival.content');

    Route::get('festival/events/{id}', [FestivalCompatController::class, 'festivalEventShow'])
        ->middleware('cache.headers:public;max_age=600;etag')
        ->name('festival.events.show');

    Route::get('locations', [FestivalCompatController::class, 'locationsIndex'])
        ->middleware('cache.headers:public;max_age=600;etag')
        ->name('locations.index');

    Route::get('locations/{id}', [FestivalCompatController::class, 'locationsShow'])
        ->middleware('cache.headers:public;max_age=600;etag')
        ->name('locations.show');

    Route::get('map/venues', [FestivalCompatController::class, 'mapVenuesIndex'])
        ->middleware('cache.headers:public;max_age=600;etag')
        ->name('map.venues.index');

    Route::get('map/venues/{id}', [FestivalCompatController::class, 'mapVenuesShow'])
        ->middleware('cache.headers:public;max_age=600;etag')
        ->name('map.venues.show');

    Route::get('pages/{id}', [FestivalCompatController::class, 'pageShow'])
        ->middleware('cache.headers:public;max_age=3600;etag')
        ->name('pages.show');

    Route::get('feeds/{id}', [FestivalCompatController::class, 'feedShow'])
        ->middleware('cache.headers:public;max_age=300;etag')
        ->name('feeds.show');

    Route::get('feeds/{id}/posts', [FestivalCompatController::class, 'feedPostsIndex'])
        ->middleware('cache.headers:public;max_age=300;etag')
        ->name('feeds.posts.index');

    Route::get('posts/{id}', [FestivalCompatController::class, 'postShow'])
        ->middleware('cache.headers:public;max_age=300;etag')
        ->name('posts.show');

    Route::get('stream', [FestivalCompatController::class, 'streamIndex'])
        ->middleware('cache.headers:public;max_age=60;etag')
        ->name('stream.index');
});

Route::group([
    'middleware' => ['api'],
    'prefix' => 'v2',
    'as' => 'v2.',
], function () {
    Route::get('tracker', [TrackerController::class, 'index'])
        ->middleware('cache.headers:public;max_age=300;etag')
        ->name('tracker.index');
});
