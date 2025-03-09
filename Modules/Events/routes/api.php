<?php

use Illuminate\Support\Facades\Route;
use Modules\Events\Http\Controllers\API\EventController;

Route::group([
    'prefix' => 'v1',
    'as' => 'v1.',
], function () {

    Route::get('/events/overview', [EventController::class, 'overview'])->name('events.overview');

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

});
