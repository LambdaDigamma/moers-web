<?php

use Illuminate\Support\Facades\Route;
use Modules\Locations\Http\Controllers\LocationsController;

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

Route::middleware(['web', 'auth', 'admin.access'])->group(function () {
    Route::get('locations/create', [LocationsController::class, 'create'])->name('locations.create');
    Route::post('locations', [LocationsController::class, 'store'])->name('locations.store');
    Route::get('locations/{location}/edit', [LocationsController::class, 'edit'])->name('locations.edit');
    Route::put('locations/{location}', [LocationsController::class, 'update'])->name('locations.update');
    Route::delete('locations/{location}', [LocationsController::class, 'destroy'])->name('locations.destroy');
});
