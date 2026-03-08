<?php

use Illuminate\Support\Facades\Route;
use Modules\Waste\Http\Controllers\RubbishController;

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

Route::get('abfallkalender', [RubbishController::class, 'index'])->name('rubbish.index');
Route::get('abfallkalender/{street}', [RubbishController::class, 'show'])->name('rubbish.show');
