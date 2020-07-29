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

    Route::get('/entries')->name('admin.entries.index')->uses('AdminEntryController@index');
    Route::get('/entries/{entry}')->name('admin.entries.edit')->uses('AdminEntryController@edit');
    Route::put('/entries/{entry}')->name('admin.entries.update')->uses('AdminEntryController@update');

    Route::get('/events')->name('admin.events.index')->uses('AdminEventController@index');
    Route::get('/events/{event}')->name('admin.events.edit')->uses('AdminEventController@edit');
    Route::get('/events/create')->name('admin.events.create')->uses('AdminEventController@create');

    Route::get('/polls')->name('admin.polls.index')->uses('AdminPollsController@index');
    Route::get('/polls/create')->name('admin.polls.create')->uses('AdminPollsController@create');
    Route::post('/polls')->name('admin.polls.store')->uses('AdminPollsController@store');
    Route::get('/polls/{poll}')->name('admin.polls.edit')->uses('AdminPollsController@edit');
    Route::put('/polls/{poll}')->name('admin.polls.update')->uses('AdminPollsController@update');

    Route::get('/pages')->name('admin.pages.index')->uses('PageController@index');
    Route::get('/pages/{page}')->name('admin.pages.edit')->uses('PageController@edit');
    Route::get('/pages/{page}/preview')->name('admin.pages.preview')->uses('PageController@preview');
    Route::put('/pages/{page}')->name('admin.pages.update')->uses('PageController@update');

    Route::get('/datasets')->name('admin.datasets.index')->uses('AdminDatasetController@index');
    Route::get('/datasets/{dataset}')->name('admin.datasets.edit')->uses('AdminDatasetController@edit');

    Route::get('/datasets/{dataset}/resources/create')->name('admin.datasets.resources.create')->uses('AdminDatasetResourceController@create');
    Route::post('/datasets/{dataset}/resources')->name('admin.datasets.resources.store')->uses('AdminDatasetResourceController@storeResource');
    Route::get('/datasets/{dataset}/resources/{resource}')->name('admin.datasets.resources.edit')->uses('AdminDatasetResourceController@edit');
    Route::put('/datasets/{dataset}/resources/{resource}')->name('admin.datasets.resources.update')->uses('AdminDatasetResourceController@update');
    Route::post('/datasets/{dataset}/resources/{resource}/update')->name('admin.datasets.resources.updateData')->uses('AdminDatasetResourceController@loadResource');
    Route::get('/moers-festival/stream')->name('admin.moers-festival.stream')->uses('AdminOrganisationController@stream');
    Route::put('/moers-festival/stream')->name('admin.moers-festival.stream.update')->uses('AdminOrganisationController@updateStream');

    Route::get('/forms/students')->name('admin.forms.students')->uses('AdminStudentController@index');
    Route::get('/forms/students/{student_information}')->name('admin.forms.students.show')->uses('AdminStudentController@show');

});


