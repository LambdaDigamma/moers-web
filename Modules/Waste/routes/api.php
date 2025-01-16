<?php

use Illuminate\Support\Facades\Route;
use Modules\Waste\Http\Controllers\V1\RubbishStreetController as RubbishStreetControllerV1;
use Modules\Waste\Http\Controllers\V2\RubbishStreetController as RubbishStreetControllerV2;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/


Route::group(['prefix' => '/v1', 'as' => 'v1.'], function () {

    Route::get('/rubbish/streets/{street}/pickups', [RubbishStreetControllerV1::class, 'show'])->name('rubbish.streets.pickups.index');
    Route::get('/rubbish/streets', [RubbishStreetControllerV1::class, 'index'])->name('rubbish.streets.index');

});

Route::group(['prefix' => '/v2', 'as' => 'v2.'], function () {

    Route::get('/rubbish/streets/{street}/pickups', [RubbishStreetControllerV2::class, 'show'])->name('rubbish.streets.pickups.index');
    Route::get('/rubbish/streets', [RubbishStreetControllerV2::class, 'index'])->name('rubbish.streets.index');

});
