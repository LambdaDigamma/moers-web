<?php

use Illuminate\Support\Facades\Route;

Route::get('/rubbish/streets', 'API\APIRubbishController@streetList')
     ->name('api.v2.rubbish.streets');

Route::get('/rubbish/streets/{street}/pickups', 'API\APIRubbishController@pickupItems')
     ->name('api.v2.rubbish.pickups');