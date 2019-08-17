<?php

use Illuminate\Support\Facades\Route;

Route::get('/groups', 'API\APIGroupController@index')
    ->name('api.v2.groups');

