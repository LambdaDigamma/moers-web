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
Route::get('logout')->name('logout.seamless')->uses('Auth\LoginController@logout');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('/login/apple', 'SiwaController@login');
Route::post('/login/apple/callback', 'SiwaController@callback');

Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register')->name('register.attempt');

Route::group([
    'namespace' => 'Web',
], function () {

    Route::get('/')->name('landingPage')->uses('LandingPageController');

    Route::get('/notifications')->name('notifications')->uses('ProfileController@notifications')->middleware('auth');
    Route::get('/profile')->name('profile')->uses('ProfileController@details')->middleware('auth');
    Route::put('/profile')->name('profile.update')->uses('ProfileController@updateInformation')->middleware('auth');
    Route::post('/profile/export')->name('profile.export')->uses('ProfileController@exportData')->middleware('auth');
    Route::delete('/profile')->name('profile.delete')->uses('ProfileController@deleteAccount')->middleware('auth');

    Route::get('/legal/privacy')->name('legal.privacy')->uses('LegalController@privacy');
    Route::get('/legal/imprint')->name('legal.imprint')->uses('LegalController@imprint');
    Route::get('/legal/tac')->name('legal.tac')->uses('LegalController@tac');

    Route::get('/dashboard')->name('dashboard')->uses('DashboardController');

    Route::get('/help')->name('help.index')->uses('HelpController@index');
    Route::get('/help/serve')->name('help.serve')->uses('HelpController@serve');
    Route::get('/help/need')->name('help.need')->uses('HelpController@need')->middleware('auth');
    Route::post('/help/need')->name('help.need.store')->uses('HelpController@sendHelpRequest')->middleware('auth');
    Route::get('/help/request/{helpRequest}')->name('help.request.show')->uses('HelpController@helpRequest')->middleware('auth');
    Route::delete('/help/request/{helpRequest}')->name('help.request.delete')->uses('HelpController@deleteHelpRequest')->middleware(['auth']);
    Route::put('/help/request/{helpRequest}/accept')->name('help.request.accept')->uses('HelpController@acceptHelpRequest')->middleware(['auth']);
    Route::post('/help/request/{helpRequest}/messages')->name('help.request.sendMessage')->uses('HelpController@sendMessage')->middleware(['auth']);
    Route::post('/help/request/{helpRequest}/done')->name('help.request.done')->uses('HelpController@done')->middleware(['auth']);
    Route::post('/help/request/{helpRequest}/quit')->name('help.request.quit')->uses('HelpController@quitHelpRequest')->middleware(['auth']);


    Route::get('/forms/students')->name('forms.student')->uses('FormController@student')->middleware('auth');
    Route::post('/forms/students')->name('forms.student.save')->uses('FormController@saveStudentForm')->middleware('auth');

    Route::get('/polls')->name('polls.index')->uses('PollController@index')->middleware('auth');
    Route::get('/polls/answered')->name('polls.index.answered')->uses('PollController@indexAnswered')->middleware('auth');
    Route::get('/polls/{poll}')->name('polls.show')->uses('PollController@show')->middleware('auth');
    Route::post('/polls/{poll}/vote')->name('polls.vote')->uses('PollController@vote')->middleware('auth');
    Route::post('/polls/{poll}/abstain')->name('polls.abstain')->uses('PollController@abstain')->middleware('auth');

    Route::personalDataExports('personal-data-exports');

});

Route::post('/mailinglist/subscribe', 'MailingListController@subscribe')->name('mailinglist.subscribe');
