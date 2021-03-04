<?php

Route::get('/groups', 'API\APIGroupController@all')
     ->middleware('can:read-group,App\Group')
     ->name('api.v2.admin.groups');

Route::get('/groups/{id}', 'API\APIGroupController@get')
     ->where('id', '[1-9][0-9]*')
     ->middleware('can:read-group,App\Group')
     ->name('api.v2.admin.group');

Route::put('/groups/{group}', 'API\APIGroupController@update')
     ->middleware([
         'can:read-group,App\Models\User',
         'can:update-group,App\Group',
     ])
     ->name('api.v2.admin.group.update');

Route::post('/groups/{group}/allowCreatePoll', 'API\APIGroupController@allowCreatePoll')
     ->middleware([
         'can:read-group,App\Models\User',
         'can:update-group,App\Group',
     ])
     ->name('api.v2.admin.group.allowCreatePoll');

Route::post('/groups/{group}/disallowCreatePoll', 'API\APIGroupController@disallowCreatePoll')
     ->middleware([
         'can:read-group,App\Models\User',
         'can:update-group,App\Group',
     ])
     ->name('api.v2.admin.group.disallowCreatePoll');
