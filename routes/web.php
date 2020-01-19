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

Route::get('/admin/dashboard')->name('admin.dashboard')->uses('AdminDashboardController')->middleware('auth');
Route::get('/admin/polls')->name('admin.polls.index')->uses('AdminPollsController@index')->middleware('auth');

Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm')->middleware('guest');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login')->middleware('guest');

//Route::get('/login')->name('login')->

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


