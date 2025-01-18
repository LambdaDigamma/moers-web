<?php

use App\Http\Controllers\MapAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/maps/auth', [MapAuthController::class, 'token']);
