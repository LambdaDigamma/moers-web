<?php

Route::get('/groups', 'API\APIGroupController@all')
    ->middleware('can:read-group,App\Group')
    ->name('api.v2.admin.groups');

Route::get('/groups/{id}', 'API\APIGroupController@get')
    ->where('id', '[1-9][0-9]*')
    ->middleware('can:read-group,App\Group')
    ->name('api.v2.admin.group');

Route::put('/groups/{group}', 'API\APIGroupController@update')
    ->middleware(['can:read-group,App\User', 'can:update-group,App\Group'])
    ->name('api.v2.admin.group.update');
