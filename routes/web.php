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
    return view('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/account/edit', 'UserController@edit')->name('account.edit');
Route::patch('/account/update', 'UserController@update')->name('account.update');
Route::post('/account/changepassword', 'UserController@changePassword')->name('account.changepassword');
Route::delete('/account/delete', 'UserController@destroy')->name('account.delete');
Route::resource('users', 'UserController')->only([
    'index',
]);
