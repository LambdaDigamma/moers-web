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

Route::get('/', function () {
    return view('legacy.index');
})->name('index');

Route::post('/mailinglist/subscribe', 'MailingListController@subscribe')->name('mailinglist.subscribe');

Route::get('admin/dashboard', 'AdminController@index')->name('admin');

/* Admin - Shops */

Route::get('admin/shops', 'ShopController@index')->name('shops.index');
Route::post('admin/shops', 'ShopController@store')->name('shops.store');
Route::delete('admin/shops/{id}', 'ShopController@destroy')->name('shops.destroy')->where(['id' => '[0-9]+']);
Route::get('admin/shops/{id}/edit', 'ShopController@edit')->name('shops.edit')->where(['id' => '[0-9]+']);
Route::put('admin/shops/{id}', 'ShopController@update')->name('shops.update')->where(['id' => '[0-9]+']);
Route::post('admin/shops/{id}/approve', 'ShopController@approve')->name('shops.approve')->where(['id' => '[0-9]+']);
Route::post('admin/shops/{id}/reject', 'ShopController@reject')->name('shops.reject')->where(['id' => '[0-9]+']);

/* Admin - Activities */

Route::get('admin/activities', 'ActivityController@index')->name('activities.index');

/* Portal */

Route::get('/portal/menu', 'PortalController@menu')->name('portal.menu');
Route::get('/portal', 'PortalController@index')->name('portal.index');
Route::get('/shops/create', 'ShopController@create')->name('shops.create');
//Route::get('/shops/store', 'ShopController@store')->name('shops.store');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();