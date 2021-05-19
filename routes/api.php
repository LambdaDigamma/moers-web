<?php

use App\Models\Event;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes v2
|--------------------------------------------------------------------------
*/

/* Organisations */

Route::group(['prefix' => '/v2'], function () {

    /* Basic */

    Route::get('/organisations', 'API\APIOrganisationController@get')
        ->name('api.v2.organisations.get');

    Route::get('/organisations/{id}', 'API\APIOrganisationController@show')
        ->where('id', '[1-9][0-9]*')
        ->name('api.v2.organisations.show');

    Route::post('/organisations', 'API\APIOrganisationController@store')
        ->name('api.v2.organisations.store');

    Route::put('/organisations/{organisation}', 'API\APIOrganisationController@update')
        ->name('api.v2.organisations.update');

    Route::delete('/organisations/{organisation}', 'API\APIOrganisationController@delete')
        ->name('api.v2.organisations.delete');

    /* Users */

    Route::get('/organisations/{organisation}/users', 'API\APIOrganisationController@getUsers')
        ->name('api.v2.organisations.users');

    Route::post('/organisations/{organisation}/join', 'API\APIOrganisationController@join')
        ->name('api.v2.organisations.join');

    Route::post('/organisations/{organisation}/leave', 'API\APIOrganisationController@leave')
        ->name('api.v2.organisations.leave');

    Route::post('/organisations/{organisation}/makeAdmin', 'API\APIOrganisationController@makeAdmin')
        ->name('api.v2.organisations.makeAdmin');

    Route::post('/organisations/{organisation}/makeMember', 'API\APIOrganisationController@makeMember')
        ->name('api.v2.organisations.makeMember');

    Route::post('/organisations/{organisation}/addUser', 'API\APIOrganisationController@addUser')
        ->name('api.v2.organisations.addUser');

    Route::post('/organisations/{organisation}/removeUser', 'API\APIOrganisationController@removeUser')
        ->name('api.v2.organisations.removeUser');

    /* Events */

    // Route::get('/organisations/{organisation}/events', 'API\APIOrganisationController@getEvents')
    //     ->name('api.v2.organisations.events');

    // Route::post('/organisations/{organisation}/events', 'API\APIOrganisationController@storeEvent')
    //     ->name('api.v2.organisations.events.store');

    // Route::delete('/organisations/{oID}/events/{eID}', 'API\APIOrganisationController@deleteEvent')
    //     ->where('oID', '[1-9][0-9]*')
    //     ->where('eID', '[1-9][0-9]*')
    //     ->name('api.v2.organisations.events.delete');

    /* Entry */

    Route::get('/organisations/{organisation}/entry', 'API\APIOrganisationController@getEntry')
        ->name('api.v2.organisations.entry');

    Route::post('/organisations/{organisation}/entry', 'API\APIOrganisationController@associateEntry')
        ->name('api.v2.organisations.entry.associate');

    Route::delete('/organisations/{organisation}/entry', 'API\APIOrganisationController@detachEntry')
        ->name('api.v2.organisations.entry.detach');


    /* moers festival */

    Route::get('/moers-festival/events', 'MoersFestivalController@getEvents')
        ->name('api.v2.moersfestival.get');

    Route::get('/moers-festival/events/all', 'MoersFestivalController@getAllEvents')
        ->name('api.v2.moersfestival.getAll');

    Route::get('/moers-festival/stream', 'MoersFestivalController@getStream');

    Route::post('/moers-festival/events', 'MoersFestivalController@store')
        ->middleware('auth:api')
        ->name('api.v2.moersfestival.store');
});

/* Events */

Route::group(['prefix' => '/v2'], function () {
    // Route::get('/events', 'API\APIEventController@get')
    //     ->name('api.v2.events.get');

    // Route::get('/events/{id}', 'API\APIEventController@show')
    //     ->where('id', '[1-9][0-9]*')
    //     ->name('api.v2.events.show');

    // Route::post('/events', 'API\APIEventController@store')
    //     ->name('api.v2.events.store');

    // Route::put('/events/{event}', 'API\APIEventController@update')
    //     ->name('api.v2.events.update');

    // Route::delete('/organisations/{event}', 'API\APIEventController@delete')
    //     ->name('api.v2.events.delete');

    Route::get('/advEvents', 'API\APIEventController@getAdvEvents')
        ->name('api.v2.advEvents.get');

    Route::get('/advEvents/keyed', 'API\APIEventController@getAdvEventsKeyed')
        ->name('api.v2.advEvents.get.keyed');
});

/* Entries */

Route::group(['prefix' => '/v2'], function () {
    Route::get('/entries', 'API\APIEntryController@get')
        ->name('api.v2.entries.get');

    Route::post('/entries', 'API\APIEntryController@store')
        ->name('api.v2.entries.store');

    Route::put('/entries/{entry}', 'API\APIEntryController@update')
        ->name('api.v2.entries.update');

    Route::get('/entries/{entry}/history', 'API\APIEntryController@getHistory')
         ->name('api.v2.entries.history');
});

/* Tracker */

Route::group(['prefix' => '/v2'], function () {
    Route::get('/tracker', 'API\APITrackerController@get')
        ->name('api.v2.tracker.get');
});

/* Auth */

Route::group(['prefix' => '/v2'], function () {
    Route::prefix('/auth')->group(function () {

//        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::get('refresh', 'AuthController@refresh');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::get('user', 'AuthController@user');
            Route::post('logout', 'AuthController@logout');
        });
    });
});

/* Admin */

Route::group(['prefix' => '/v2'], function () {
    Route::get('/polls', 'API\APIPollController@index')
        ->name('api.v2.polls');

    Route::get('/polls/{id}', 'API\APIPollController@show')
        ->where('id', '[1-9][0-9]*')
        ->name('api.v2.polls.show');

    Route::get('/polls/unanswered', 'API\APIPollController@unansweredPolls')
        ->name('api.v2.polls.unanswered');

    Route::get('/polls/answered', 'API\APIPollController@answeredPolls')
        ->name('api.v2.polls.answered');

    Route::post('/polls', 'API\APIPollController@store')
        ->middleware('can:create-poll,App\Models\Poll')
        ->name('api.v2.polls.store');

    Route::post('polls/{poll}/abstain', 'API\APIPollController@abstain') // TODO: Add Ability Middleware for Voting
        ->name('api.v2.poll.abstain');

    Route::post('polls/{poll}/vote', 'API\APIPollController@vote') // TODO: Add Ability Middleware for Voting
        ->name('api.v2.poll.vote');
});

/*
|--------------------------------------------------------------------------
| API Routes v1
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => '/v1'], function () {

    /* Events */

    Route::get('/events', 'API\APIEventController@get')->name('api.v1.events.get');

    /* Entries */

    Route::get('/entries', 'API\APIEntryController@get')->name('api.v1.entries.get');
    Route::post('/entries', 'API\APIEntryController@store')->name('api.v1.entries.store');
    Route::put('/entries/{entry}', 'API\APIEntryController@update')->name('api.v1.entries.update');
    Route::get('/entries/{entry}/history', 'API\APIEntryController@getHistory')->name('api.v1.entries.history.get');
});


/*
|--------------------------------------------------------------------------
| API Routes Deprecated
|--------------------------------------------------------------------------
*/


Route::get('/events', function () {
    return Event::all();
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'
    ], 404);
});
