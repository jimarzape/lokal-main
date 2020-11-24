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

// Route::get('/', function () {
//     return view('home');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::post('sign-in','Auth\SignInController@sign_in')->name('signin');
Route::post('sign-up','Auth\SignInController@signup')->name('signup');



Route::get('/test','TestController@index');
Route::get('/test/rate','TestController@rate');