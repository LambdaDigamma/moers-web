<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Shop;
use \App\Event;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
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

    Route::delete('/organisations/{organisation}','API\APIOrganisationController@delete')
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

    Route::get('/organisations/{organisation}/events', 'API\APIOrganisationController@getEvents')
        ->name('api.v2.organisations.events');

    Route::post('/organisations/{organisation}/events', 'API\APIOrganisationController@storeEvent')
        ->name('api.v2.organisations.events.store');

    Route::delete('/organisations/{oID}/events/{eID}', 'API\APIOrganisationController@deleteEvent')
        ->where('oID', '[1-9][0-9]*')
        ->where('eID', '[1-9][0-9]*')
        ->name('api.v2.organisations.events.delete');

    /* Entry */

    Route::get('/organisations/{organisation}/entry', 'API\APIOrganisationController@getEntry')
        ->name('api.v2.organisations.entry');

    Route::post('/organisations/{organisation}/entry', 'API\APIOrganisationController@associateEntry')
        ->name('api.v2.organisations.entry.associate');

    Route::delete('/organisations/{organisation}/entry', 'API\APIOrganisationController@detachEntry')
        ->name('api.v2.organisations.entry.detach');

    // Entries
    /// CREATE
    /// READ
    /// UPDATE
    /// DELETE

});

/* Events */

Route::group(['prefix' => '/v2'], function () {

    Route::get('/events', 'API\APIEventController@get')
        ->name('api.v2.events.get');

    Route::get('/events/{id}', 'API\APIEventController@show')
        ->where('id', '[1-9][0-9]*')
        ->name('api.v2.events.show');

    Route::post('/events', 'API\APIEventController@store')
        ->name('api.v2.events.store');

    Route::put('/events/{event}', 'API\APIEventController@update')
        ->name('api.v2.events.update');

    Route::delete('/organisations/{event}','API\APIEventController@delete')
        ->name('api.v2.events.delete');

});

/* Entries */

Route::group(['prefix' => '/v2'], function () {

    Route::get('/entries', 'API\APIEntryController@get')
        ->name('api.v2.entries.get');

    Route::post('/entries', 'API\APIEntryController@store');

});












/* ---- Auth Required ---- */

Route::group(['middleware' => ['auth:api'],
              'prefix' => '/v1'], function() {

    Route::get('/user', 'API\APIUserController@getUser')->name('api.v1.user.getUser');
    Route::get('/leaderboard/top', 'LeaderboardController@topUser')->name('api.v1.leaderboard.topUser');
    Route::get('/leaderboard/me', 'LeaderboardController@userRanking')->name('api.v1.leaderboard.me');

});



/* ---- Common ---- */

Route::group(['prefix' => '/v1'], function () {

//    Route::post('/register', 'API\APIUserController@register')->name('api.v1.user.register');
    Route::get('/events', 'API\APIEventController@getEvents')->name('api.v1.events.get');
    Route::get('/shops', 'API\APIShopController@getShops')->name('api.v1.shops.getShops');
    Route::post('/shops', 'API\APIShopController@store')->name('api.v1.shops.store');
    Route::get('/entries', 'API\APIEntryController@get')->name('api.v1.entries.get');
    Route::post('/entries', 'API\APIEntryController@store')->name('api.v1.entries.store');
    Route::put('/entries/{entry}', 'API\APIEntryController@update')->name('api.v1.entries.update');

});



/* ---- Deprecated ---- */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/shops', function () {
    return Shop::where('validated', '=', '1')->get();
});

Route::get('/events', function () {
    return Event::all();
});

Route::middleware('auth:api')->get('/leaderboard/top', 'LeaderboardController@topUser')->name('leaderboard.topUser');
Route::middleware('auth:api')->get('/leaderboard/me', 'LeaderboardController@userRanking')->name('leaderboard.me');
Route::middleware('auth:api')->post('/shops/store', 'ShopController@store')->name('shop.store');