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

Auth::routes();

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/portal/menu', 'PortalController@menu')->name('portal.menu');
Route::get('/portal', 'PortalController@index')->name('portal.index');
Route::get('/shops/create', 'ShopController@create')->name('shops.create');
Route::get('/shops/store', 'ShopController@store')->name('shops.store');
Route::get('/home', 'HomeController@index')->name('home');