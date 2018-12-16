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

Route::group(['prefix' => '/v2'], function () {

    // Organisations

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

    Route::post('/organisations/{id}/join', 'API\APIOrganisationController@join')
        ->where('id', '[1-9][0-9]*')
        ->name('api.v2.organisations.join');

    Route::post('/organisations/{id}/leave', 'API\APIOrganisationController@leave')
        ->where('id', '[1-9][0-9]*')
        ->name('api.v2.organisations.leave');

    // Events
    /// CREATE
    /// READ
    /// UPDATE
    /// DELETE


    // Entries
    /// CREATE
    /// READ
    /// UPDATE
    /// DELETE

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