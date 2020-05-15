<?php

Route::group([
    'prefix' => '/admin',
    'namespace' => 'Admin',
    'middleware' => ['can:access-admin', 'auth']
], function () {

    Route::get('/dashboard')->name('admin.dashboard')->uses('AdminDashboardController');
    Route::get('/organisations')->name('admin.organisations.index')->uses('AdminOrganisationController@index');
    Route::get('/organisations/create')->name('admin.organisations.create')->uses('AdminOrganisationController@create');
    Route::get('/organisations/{organisation}')->name('admin.organisations.edit')->uses('AdminOrganisationController@edit');
    Route::delete('/organisations/{organisation}')->name('admin.organisations.destroy')->uses('AdminOrganisationController@destroy');
    Route::put('/organisations/{organisation}/restore')->name('admin.organisations.restore')->uses('AdminOrganisationController@restore');
    Route::get('/organisations/{organisation}/events/create')->name('admin.organisations.events.create')->uses('AdminOrganisationController@createEvent');
    Route::post('/organisations/{organisation}/events')->name('admin.organisations.events.store')->uses('AdminOrganisationController@storeEvent');
    Route::get('/organisations/{organisation}/events/{event}/{lang?}')->name('admin.organisations.events.edit')->uses('AdminOrganisationController@editEvent');
    Route::put('/organisations/{organisation}/events/{event}/{lang?}')->name('admin.organisations.events.update')->uses('AdminOrganisationController@updateEvent');
    Route::put('/organisations/{organisation}/events/{event}/page/{lang?}')->name('admin.organisations.events.page.update')->uses('AdminOrganisationController@updatePage');

    Route::get('/polls')->name('admin.polls.index')->uses('AdminPollsController@index');
    Route::get('/polls/create')->name('admin.polls.create')->uses('AdminPollsController@create');
    Route::post('/polls')->name('admin.polls.store')->uses('AdminPollsController@store');
    Route::get('/polls/{poll}')->name('admin.polls.edit')->uses('AdminPollsController@edit');
    Route::put('/polls/{poll}')->name('admin.polls.update')->uses('AdminPollsController@update');

    Route::get('/pages')->name('admin.pages.index')->uses('PageController@index');
    Route::get('/pages/{page}')->name('admin.pages.edit')->uses('PageController@edit');
    Route::get('/pages/{page}/preview')->name('admin.pages.preview')->uses('PageController@preview');
    Route::put('/pages/{page}')->name('admin.pages.update')->uses('PageController@update');

    Route::get('/moers-festival/stream')->name('admin.moers-festival.stream')->uses('AdminOrganisationController@stream');
    Route::put('/moers-festival/stream')->name('admin.moers-festival.stream.update')->uses('AdminOrganisationController@updateStream');

});


