<?php

use Illuminate\Support\Facades\Route;
use Modules\Events\Http\Controllers\OrganisationEventsController;
use Modules\Management\Http\Controllers\OrganisationController;

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

Route::get('organisations/create', [OrganisationController::class, 'create'])->name('organisations.create');
Route::post('organisations', [OrganisationController::class, 'store'])->name('organisations.store');
Route::get('organisations/{organisation:slug}', [OrganisationController::class, 'show'])->name('organisations.show');
Route::get('organisations/{organisation:slug}/edit', [OrganisationController::class, 'edit'])->name('organisations.edit');
Route::get('organisations/{organisation:slug}/events', [OrganisationEventsController::class, 'index'])->name('organisations.events.index');
Route::get('organisations', [OrganisationController::class, 'index'])->name('organisations.index');
