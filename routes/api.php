<?php

use App\Http\Controllers\API\APIEntryController;
use App\Http\Controllers\API\APIOrganisationController;
use App\Http\Controllers\API\APIPollController;
use App\Http\Controllers\API\APITrackerController;
use App\Http\Controllers\API\RadioBroadcastController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes v2
|--------------------------------------------------------------------------
*/

/* Organisations */

Route::group(['prefix' => '/v2'], function () {

    /* Basic */

    Route::get('/organisations', [APIOrganisationController::class, 'get'])->name('api.v2.organisations.get');
    Route::get('/organisations/{id}', [APIOrganisationController::class, 'show'])->where('id', '[1-9][0-9]*')->name('api.v2.organisations.show');
    Route::post('/organisations', [APIOrganisationController::class, 'store'])->name('api.v2.organisations.store');
    Route::put('/organisations/{organisation}', [APIOrganisationController::class, 'update'])->name('api.v2.organisations.update');
    Route::delete('/organisations/{organisation}', [APIOrganisationController::class, 'delete'])->name('api.v2.organisations.delete');

    /* Users */

    Route::get('/organisations/{organisation}/users', [APIOrganisationController::class, 'getUsers'])->name('api.v2.organisations.users');
    Route::post('/organisations/{organisation}/join', [APIOrganisationController::class, 'join'])->name('api.v2.organisations.join');
    Route::post('/organisations/{organisation}/leave', [APIOrganisationController::class, 'leave'])->name('api.v2.organisations.leave');

    Route::post('/organisations/{organisation}/makeAdmin', [APIOrganisationController::class, 'makeAdmin'])->name('api.v2.organisations.makeAdmin');
    Route::post('/organisations/{organisation}/makeMember', [APIOrganisationController::class, 'makeMember'])->name('api.v2.organisations.makeMember');
    Route::post('/organisations/{organisation}/addUser', [APIOrganisationController::class, 'addUser'])->name('api.v2.organisations.addUser');

    Route::post('/organisations/{organisation}/removeUser', [APIOrganisationController::class, 'removeUser'])->name('api.v2.organisations.removeUser');

    /* Entry */

    Route::get('/organisations/{organisation}/entry', [APIOrganisationController::class, 'getEntry'])->name('api.v2.organisations.entry');
    Route::post('/organisations/{organisation}/entry', [APIOrganisationController::class, 'associateEntry'])->name('api.v2.organisations.entry.associate');
    Route::delete('/organisations/{organisation}/entry', [APIOrganisationController::class, 'detachEntry'])->name('api.v2.organisations.entry.detach');

});


/* Entries */

Route::group(['prefix' => '/v2'], function () {
    Route::get('/entries', [APIEntryController::class, 'get'])->name('api.v2.entries.get');
    Route::post('/entries', [APIEntryController::class, 'store'])->name('api.v2.entries.store');
    Route::put('/entries/{entry}', [APIEntryController::class, 'update'])->name('api.v2.entries.update');
    Route::get('/entries/{entry}/history', [APIEntryController::class, 'getHistory'])->name('api.v2.entries.history');
});

/* Tracker */

Route::group(['prefix' => '/v2'], function () {
    Route::get('/tracker', [APITrackerController::class, 'get'])
        ->name('api.v2.tracker.get');
});

/* Auth */

Route::group(['prefix' => '/v2'], function () {
    Route::prefix('/auth')->group(function () {

        Route::post('login', [AuthController::class, 'login']);

        Route::group(['middleware' => 'auth:api'], function () {
            Route::get('user', [AuthController::class, 'user']);
            Route::post('logout', [AuthController::class, 'logout']);
        });
    });
});

/* Admin */

Route::group(['prefix' => '/v2'], function () {
    Route::get('/polls', [APIPollController::class, 'index'])->name('api.v2.polls');
    Route::get('/polls/{id}', [APIPollController::class, 'show'])->where('id', '[1-9][0-9]*')->name('api.v2.polls.show');
    Route::get('/polls/unanswered', [APIPollController::class, 'unansweredPolls'])->name('api.v2.polls.unanswered');
    Route::get('/polls/answered', [APIPollController::class, 'answeredPolls'])->name('api.v2.polls.answered');
    Route::post('/polls', [APIPollController::class, 'store'])->middleware('can:create-poll,App\Models\Poll')->name('api.v2.polls.store');
    Route::post('polls/{poll}/abstain', [APIPollController::class, 'abstain'])->name('api.v2.poll.abstain');
    Route::post('polls/{poll}/vote', [APIPollController::class, 'vote'])->name('api.v2.poll.vote');
});

/*
|--------------------------------------------------------------------------
| API Routes v1
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => '/v1'], function () {

    /* Entries */

    Route::get('/entries', [APIEntryController::class, 'get'])->name('api.v1.entries.get');
    Route::post('/entries', [APIEntryController::class, 'store'])->name('api.v1.entries.store');
    Route::put('/entries/{entry}', [APIEntryController::class, 'update'])->name('api.v1.entries.update');
    Route::get('/entries/{entry}/history', [APIEntryController::class, 'getHistory'])->name('api.v1.entries.history.get');

    Route::get('/radio-broadcasts', [RadioBroadcastController::class, 'index'])->name('api.v1.radio-broadcasts.index');
    Route::get('/radio-broadcasts/{radioBroadcast}', [RadioBroadcastController::class, 'show'])->name('api.v1.radio-broadcasts.show');

});
