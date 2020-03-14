<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm')->middleware('guest');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login')->middleware('guest');
Route::post('logout')->name('logout')->uses('Auth\LoginController@logout');

Route::get('/login/apple', 'SiwaController@login');
Route::post('/login/apple/callback', 'SiwaController@callback');

Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

Route::group([
    'namespace' => 'Web',
], function () {

    Route::get('/')->name('landingPage')->uses('LandingPageController');

    Route::get('/profile')->name('profile')->uses('ProfileController@details');

    Route::get('/legal/privacy')->name('legal.privacy')->uses('LegalController@privacy');
    Route::get('/legal/imprint')->name('legal.imprint')->uses('LegalController@imprint');
    Route::get('/legal/tac')->name('legal.tac')->uses('LegalController@tac');

    Route::get('/dashboard')->name('dashboard')->uses('DashboardController')->middleware('auth');

    Route::get('/forms/students')->name('forms.student')->uses('FormController@student')->middleware('auth');
    Route::post('/forms/students')->name('forms.student.save')->uses('FormController@saveStudentForm')->middleware('auth');

    Route::get('/polls')->name('polls.index')->uses('PollController@index')->middleware('auth');
    Route::get('/polls/answered')->name('polls.index.answered')->uses('PollController@indexAnswered')->middleware('auth');
    Route::get('/polls/{poll}')->name('polls.show')->uses('PollController@show')->middleware('auth');
    Route::post('/polls/{poll}/vote')->name('polls.vote')->uses('PollController@vote')->middleware('auth');
    Route::post('/polls/{poll}/abstain')->name('polls.abstain')->uses('PollController@abstain')->middleware('auth');

});

Route::post('/mailinglist/subscribe', 'MailingListController@subscribe')->name('mailinglist.subscribe');
