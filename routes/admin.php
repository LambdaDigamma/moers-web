<?php

Route::group([
    'prefix' => '/admin',
    'middleware' => ['can:access-admin', 'auth']
], function () {

        Route::get('/dashboard')->name('admin.dashboard')->uses('Admin\AdminDashboardController');
        Route::get('/organisations')->name('admin.organisations.index')->uses('Admin\AdminOrganisationController@index');
        Route::get('/organisations/{organisation}')->name('admin.organisations.edit')->uses('Admin\AdminOrganisationController@edit');
        Route::delete('/organisations/{organisation}')->name('admin.organisations.destroy')->uses('Admin\AdminOrganisationController@destroy');
        Route::put('/organisations/{organisation}/restore')->name('admin.organisations.restore')->uses('Admin\AdminOrganisationController@restore');
        Route::get('/organisations/{organisation}/events/create')->name('admin.organisations.events.create')->uses('Admin\AdminOrganisationController@createEvent');

        Route::get('/polls')->name('admin.polls.index')->uses('Admin\AdminPollsController@index');
        Route::get('/polls/create')->name('admin.polls.create')->uses('Admin\AdminPollsController@create');
        Route::post('/polls')->name('admin.polls.store')->uses('Admin\AdminPollsController@store');
        Route::get('/polls/{poll}')->name('admin.polls.edit')->uses('Admin\AdminPollsController@edit');
        Route::put('/polls/{poll}')->name('admin.polls.update')->uses('Admin\AdminPollsController@update');

});


