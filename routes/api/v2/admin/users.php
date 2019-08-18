<?php

use Illuminate\Support\Facades\Route;

Route::get('/users', 'API\APIUserController@all')
    ->middleware('can:read-user,App\User')
    ->name('api.v2.admin.users');

Route::get('/users/{id}', 'API\APIUserController@get')
    ->where('id', '[1-9][0-9]*')
    ->middleware('can:read-user,App\User')
    ->name('api.v2.admin.user');

Route::post('/users/{id}/join', 'API\APIUserController@joinGroup')
    ->where('id', '[1-9][0-9]*')
    ->middleware('can:read-user,App\User')
    ->name('api.v2.admin.user.join');

Route::post('/users/{id}/leave', 'API\APIUserController@leaveGroup')
    ->where('id', '[1-9][0-9]*')
    ->middleware('can:read-user,App\User')
    ->name('api.v2.admin.user.leave');