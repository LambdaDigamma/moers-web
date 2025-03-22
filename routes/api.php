<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Events\Http\Controllers\API\OrganisationEventsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group([
    'middleware' => ['api'],
], function () {

    // Localization via Accept-Language header

//    Route::get('/v2/organisations/{organisation:slug}/events', [OrganisationEventsController::class, 'index']);
//    Route::get('/v2/organisations/{organisation:slug}/events/{event:slug}');
//    Route::get('/v2/organisations/{organisation:slug}/events/{event:slug}/bulk-download');
//    Route::get('/v2/organisations/{organisation:slug}/posts');

    // Should also return the events at the location (used for the map of the events)
//    Route::get('/v2/organisations/{organisation:slug}/events/{event:slug}/locations');
//    Route::get('/v2/locations/{location:slug}');

//    Route::get('/v2/posts/{post:id}');
//    Route::get('/v2/pages/{page:id}');

});
