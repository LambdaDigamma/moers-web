<?php

use Illuminate\Support\Facades\Route;
use Modules\Parking\Http\Controllers\ParkingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('parking-areas', [ParkingController::class, 'index'])->name('parking-areas.index');
Route::get('parking-areas/{parkingArea:slug}', [ParkingController::class, 'show'])->name('parking-areas.show');
