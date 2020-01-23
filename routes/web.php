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

Route::get('/')->name('landingPage')->uses('LandingPageController');

Route::get('/dashboard')->name('dashboard')->uses('DashboardController');

/*
 * Poll Routes
 */

Route::get('/polls')->name('polls.index')->uses('PollController@index')->middleware('auth');
Route::get('/polls/{poll}')->name('polls.show')->uses('PollController@show')->middleware('auth');
Route::post('/polls/{poll}/vote')->name('polls.vote')->uses('PollController@vote')->middleware('auth');
Route::post('/polls/{poll}/abstain')->name('polls.abstain')->uses('PollController@abstain')->middleware('auth');

/*
 * Admin Routes
 */

Route::get('/admin/dashboard')->name('admin.dashboard')->uses('AdminDashboardController')->middleware('auth');
Route::get('/admin/polls')->name('admin.polls.index')->uses('AdminPollsController@index')->middleware('auth');
Route::get('/admin/polls/create')->name('admin.polls.create')->uses('AdminPollsController@create')->middleware('auth');
Route::post('/admin/polls')->name('admin.polls.store')->uses('AdminPollsController@store')->middleware('auth');
Route::get('/admin/polls/{poll}')->name('admin.polls.edit')->uses('AdminPollsController@edit')->middleware('auth');
Route::put('/admin/polls/{poll}')->name('admin.polls.update')->uses('AdminPollsController@update')->middleware('auth');

/*
 * Auth Routes
 */

Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm')->middleware('guest');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login')->middleware('guest');

Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

Route::post('/mailinglist/subscribe', 'MailingListController@subscribe')->name('mailinglist.subscribe');

//Route::get('/{any}', function() {
//    return view('app');
//})->where('any', '.*');

//Route::get('/', function () {
//    return view('legacy.index');
//})->name('index');


