<?php

use Illuminate\Support\Facades\Route;
use Modules\Parking\Http\Controllers\ParkingAreaController;
use Modules\Parking\Http\Controllers\ParkingAreaDashboardController;

Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {

    Route::get('/parking/dashboard', ParkingAreaDashboardController::class)->name('parking-areas.dashboard');
    Route::get('/parking-areas', [ParkingAreaController::class, 'index'])->name('parking-areas.index');
    Route::get('/parking-areas/{parkingArea}', [ParkingAreaController::class, 'show'])->name('parking-areas.show');

});
