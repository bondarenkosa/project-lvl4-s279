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

Route::get('/', 'PagesController@index')->name('index');
Route::get('/home', 'PagesController@home')->name('home');

Route::get('users', 'ShowUsers')->name('users');

Route::get('/account/edit', 'AccountController@edit')->name('account.edit');
Route::patch('/account', 'AccountController@update')->name('account');
Route::delete('/account', 'AccountController@destroy');
Route::post('/account/changepassword', 'AccountController@changePassword')->name('account.changepassword');

Route::resource('taskstatuses', 'TaskStatusController');
