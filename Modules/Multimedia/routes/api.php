<?php

use Illuminate\Support\Facades\Route;
use Modules\Multimedia\Http\Controllers\RadioBroadcastController;

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

Route::group([
    'prefix' => 'v1',
    'as' => 'v1.',
], function () {

    Route::get('/radio-broadcasts', [RadioBroadcastController::class, 'index'])->name('api.v1.radio-broadcasts.index');
    Route::get('/radio-broadcasts/{radioBroadcast}', [RadioBroadcastController::class, 'show'])->name('api.v1.radio-broadcasts.show');

});
