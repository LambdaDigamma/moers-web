<?php

Route::group([
    'prefix' => '/admin',
    'namespace' => 'Admin',
    'middleware' => ['can:access-admin', 'auth']
], function () {

    Route::get('/dashboard')->name('admin.dashboard')->uses('AdminDashboardController');
    Route::get('/organisations')->name('admin.organisations.index')->uses('AdminOrganisationController@index');
    Route::get('/organisations/{organisation}')->name('admin.organisations.edit')->uses('AdminOrganisationController@edit');
    Route::delete('/organisations/{organisation}')->name('admin.organisations.destroy')->uses('AdminOrganisationController@destroy');
    Route::put('/organisations/{organisation}/restore')->name('admin.organisations.restore')->uses('AdminOrganisationController@restore');
    Route::get('/organisations/{organisation}/events/create')->name('admin.organisations.events.create')->uses('AdminOrganisationController@createEvent');

    Route::get('/polls')->name('admin.polls.index')->uses('AdminPollsController@index');
    Route::get('/polls/create')->name('admin.polls.create')->uses('AdminPollsController@create');
    Route::post('/polls')->name('admin.polls.store')->uses('AdminPollsController@store');
    Route::get('/polls/{poll}')->name('admin.polls.edit')->uses('AdminPollsController@edit');
    Route::put('/polls/{poll}')->name('admin.polls.update')->uses('AdminPollsController@update');

});


