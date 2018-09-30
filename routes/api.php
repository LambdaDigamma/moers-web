<?php

use Illuminate\Http\Request;
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

/* ---- Auth Required ---- */

Route::group(['middleware' => ['auth:api'],
              'prefix' => '/v1'], function() {

    Route::get('/shops', 'API\APIShopController@getShops')->name('api.v1.shops.getShops');
    Route::post('/shops', 'API\APIShopController@store')->name('api.v1.shops.store');
    Route::get('/user', 'API\APIUserController@getUser')->name('api.v1.user.getUser');
    Route::get('/leaderboard/top', 'LeaderboardController@topUser')->name('api.v1.leaderboard.topUser');
    Route::get('/leaderboard/me', 'LeaderboardController@userRanking')->name('api.v1.leaderboard.me');

});



/* ---- Common ---- */

Route::group(['prefix' => '/v1'], function () {

    Route::get('/events', 'API\APIEventController@getEvents')->name('api.v1.events.get');

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