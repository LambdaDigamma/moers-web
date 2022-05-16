<?php

use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\ParkingAreaController;
use App\Http\Controllers\API\ParkingAreaDashboardController;
use App\Http\Controllers\API\V1\RubbishController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/v1', 'as' => 'v1.'], function () {

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

    Route::get('/parking/dashboard', ParkingAreaDashboardController::class)->name('parking-areas.dashboard');
    Route::get('/parking-areas', [ParkingAreaController::class, 'index'])->name('parking-areas.index');
    Route::get('/parking-areas/{parkingArea}', [ParkingAreaController::class, 'show'])->name('parking-areas.show');

    Route::get('/rubbish/streets/{street}/pickups', [RubbishController::class, 'pickupItems'])
        ->name('rubbish.streets.pickups.index');

    Route::get('/rubbish/streets', [RubbishController::class, 'streetList'])->name('rubbish.streets.index');

});
