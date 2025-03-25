<?php

use Illuminate\Support\Facades\Route;
use Modules\Events\Http\Controllers\EventActionController;
use Modules\Events\Http\Controllers\EventController;
use Modules\Events\Http\Controllers\EventPlaceController;

Route::get('events', [EventController::class, 'index'])->name('events.index');
Route::get('events/{event:id}', [EventController::class, 'show'])->name('events.show');

Route::group([
    'prefix' => config('events.admin_prefix', 'admin'),
    'as' => config('events.admin_as', 'admin.'),
    'middleware' => config('events.admin_middleware', ['web', 'auth']),
], function () {

    /**
     * ------------------------------
     * Event Place
     * ------------------------------
     */
    Route::put('/events/{anyevent}/place', [EventPlaceController::class, 'update'])->name('events.place.update');

    /**
     * ------------------------------
     * Event General
     * ------------------------------
     */
    Route::put('/events/{anyevent}', [EventController::class, 'update'])->name('events.update');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');

    Route::post('events/{anyevent}/archive', [EventActionController::class, 'archive'])->name('events.archive');
    Route::post('events/{anyevent}/unarchive', [EventActionController::class, 'unarchive'])->name('events.unarchive');
    Route::post('events/{anyevent}/publish', [EventActionController::class, 'publish'])->name('events.publish');
    Route::post('events/{anyevent}/unpublish', [EventActionController::class, 'unpublish'])->name('events.unpublish');

});
