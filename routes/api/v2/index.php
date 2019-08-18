<?php

include base_path('routes/api/v2/groups.php');

Route::group(['prefix' => '/admin', 'middleware' => ['can:access-admin', 'auth:api']], function () {

    include base_path('routes/api/v2/admin/users.php');
    include base_path('routes/api/v2/admin/groups.php');

});