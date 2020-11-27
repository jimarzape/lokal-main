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
Route::group(['middleware' => 'auth'], function(){
	Route::get('/account','Auth\AccountController@index')->name('account');
});
Route::get('/', 'HomeController@index')->name('home');
Route::get('/products/{url}', 'ProductController@index')->name('product_url');

Route::get('/search', 'ProductController@search')->name('product_seach');
Route::get('/daily-feeds', 'ProductController@daily')->name('daily_feeds');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::post('sign-in','Auth\SignInController@sign_in')->name('signin');
Route::post('sign-up','Auth\SignInController@signup')->name('signup');



Route::get('/test','TestController@index');
Route::get('/test/rate','TestController@rate');
Route::get('/test/friendly','TestController@friendly_url');
Route::get('/test/brand_url','TestController@brand_url');
Route::get('/test/product_search','TestController@product_search');