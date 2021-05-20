<?php

Route::group([
    'prefix' => '/admin',
    'namespace' => 'Admin',
    'middleware' => ['can:access-admin', 'auth']
], function () {

    Route::get('/dashboard')->name('admin.dashboard')->uses('DashboardController');
    Route::get('/organisations')->name('admin.organisations.index')->uses('OrganisationController@index');
    Route::get('/organisations/create')->name('admin.organisations.create')->uses('OrganisationController@create');
    Route::get('/organisations/{organisation}')->name('admin.organisations.edit')->uses('OrganisationController@edit');
    Route::delete('/organisations/{organisation}')->name('admin.organisations.destroy')->uses('OrganisationController@destroy');
    Route::put('/organisations/{organisation}/restore')->name('admin.organisations.restore')->uses('OrganisationController@restore');
    Route::get('/organisations/{organisation}/events/create')->name('admin.organisations.events.create')->uses('OrganisationController@createEvent');
    Route::post('/organisations/{organisation}/events')->name('admin.organisations.events.store')->uses('OrganisationController@storeEvent');
    Route::get('/organisations/{organisation}/events/{event}/{lang?}')->name('admin.organisations.events.edit')->uses('OrganisationController@editEvent');
    Route::put('/organisations/{organisation}/events/{event}/{lang?}')->name('admin.organisations.events.update')->uses('OrganisationController@updateEvent');
    Route::put('/organisations/{organisation}/events/{event}/page/{lang?}')->name('admin.organisations.events.page.update')->uses('OrganisationController@updatePage');

    Route::get('/entries')->name('admin.entries.index')->uses('EntryController@index');
    Route::get('/entries/{entry}')->name('admin.entries.edit')->uses('EntryController@edit');
    Route::put('/entries/{entry}')->name('admin.entries.update')->uses('EntryController@update');

    Route::get('/events')->name('admin.events.index')->uses('EventController@index');
    Route::get('/events/{event}')->name('admin.events.edit')->uses('EventController@edit');
    Route::get('/events/create')->name('admin.events.create')->uses('EventController@create');

    Route::get('/polls')->name('admin.polls.index')->uses('PollsController@index');
    Route::get('/polls/create')->name('admin.polls.create')->uses('PollsController@create');
    Route::post('/polls')->name('admin.polls.store')->uses('PollsController@store');
    Route::get('/polls/{poll}')->name('admin.polls.edit')->uses('PollsController@edit');
    Route::put('/polls/{poll}')->name('admin.polls.update')->uses('PollsController@update');

    Route::get('/pages')->name('admin.pages.index')->uses('PageController@index');
    Route::get('/pages/{page}')->name('admin.pages.edit')->uses('PageController@edit');
    Route::get('/pages/{page}/preview')->name('admin.pages.preview')->uses('PageController@preview');
    Route::put('/pages/{page}')->name('admin.pages.update')->uses('PageController@update');

    Route::get('/datasets')->name('admin.datasets.index')->uses('DatasetController@index');
    Route::get('/datasets/{dataset}')->name('admin.datasets.edit')->uses('DatasetController@edit');

    Route::get('/datasets/{dataset}/resources/create')->name('admin.datasets.resources.create')->uses('DatasetResourceController@create');
    Route::post('/datasets/{dataset}/resources')->name('admin.datasets.resources.store')->uses('DatasetResourceController@storeResource');
    Route::get('/datasets/{dataset}/resources/{resource}')->name('admin.datasets.resources.edit')->uses('DatasetResourceController@edit');
    Route::put('/datasets/{dataset}/resources/{resource}')->name('admin.datasets.resources.update')->uses('DatasetResourceController@update');
    Route::post('/datasets/{dataset}/resources/{resource}/update')->name('admin.datasets.resources.updateData')->uses('DatasetResourceController@loadResource');
    Route::get('/moers-festival/stream')->name('admin.moers-festival.stream')->uses('OrganisationController@stream');
    Route::put('/moers-festival/stream')->name('admin.moers-festival.stream.update')->uses('OrganisationController@updateStream');

    Route::get('/forms/students')->name('admin.forms.students')->uses('StudentController@index');
    Route::get('/forms/students/{student_information}')->name('admin.forms.students.show')->uses('StudentController@show');

});


