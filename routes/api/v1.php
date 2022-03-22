<?php

use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\ParkingAreaController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/v1', 'as' => 'v1.'], function () {

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

    Route::get('/parking-areas', [ParkingAreaController::class, 'index'])->name('parking-areas.index');
    Route::get('/parking-areas/{parkingArea}', [ParkingAreaController::class, 'show'])->name('parking-areas.show');

});