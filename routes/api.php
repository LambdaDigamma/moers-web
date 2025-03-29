<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Events\Http\Controllers\API\OrganisationEventsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group([
    'middleware' => ['api'],
    'prefix' => 'v1/'
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
