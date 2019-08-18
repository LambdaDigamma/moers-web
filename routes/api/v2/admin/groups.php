<?php

Route::get('/groups', 'API\APIGroupController@all')
    ->middleware('can:read-group,App\Group')
    ->name('api.v2.admin.groups');
