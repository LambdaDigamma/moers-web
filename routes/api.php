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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/shops', function () {

    return Shop::where('validated', '=', '1')->get();

});

Route::get('/events', function () {

    return Event::all();

});

Route::middleware('auth:api')->group(function () {



});

Route::middleware('auth:api')->get('/leaderboard/top', 'LeaderboardController@topUser')->name('leaderboard.topUser');
Route::middleware('auth:api')->get('/leaderboard/me', 'LeaderboardController@userRanking')->name('leaderboard.me');
Route::middleware('auth:api')->get('/shops/store', 'ShopController@store')->name('shop.store');

//Route::get('/shops', function () {
//    return Shop::all();
//});