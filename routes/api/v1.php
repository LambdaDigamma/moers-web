<?php

use App\Http\Controllers\API\EventController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/v1', 'as' => 'v1.'], function () {

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

});