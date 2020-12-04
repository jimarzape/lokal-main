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
	Route::post('/account/update/info','Auth\AccountController@update_info')->name('update_info');
	Route::get('/account/manage-password','Auth\AccountController@manage_password')->name('manage_password');
	Route::post('/account/update/password','Auth\AccountController@update_password')->name('update_password');
	Route::get('/account/shipping-billing','Auth\AccountController@shipping')->name('user_shipping');
	Route::post('/account/shipping-billing/update','Auth\AccountController@update_shipping')->name('user_shipping_update');

	Route::get('/cart','CartController@index')->name('cart');
	Route::post('/cart/add','CartController@add_modal')->name('cart_add_modal');
	Route::post('/cart/update','CartController@update')->name('cart_update');
	Route::post('/cart/remove','CartController@remove')->name('cart_remove');
	Route::post('/cart/checkout-direct','CartController@checkout_direct')->name('checkout_direct');

	Route::get('/checkout','CheckoutController@index')->name('checkout');
	Route::post('/checkout/process','CheckoutController@process')->name('checkout_process');

	Route::get('/order','OrderController@index')->name('order');
	Route::get('/order/{id}','OrderController@details')->name('order_details');

	Route::post('/products/wish','ProductController@wish')->name('product_wish');
	Route::get('/wish','WishController@index')->name('wish');

});
Route::get('/', 'HomeController@index')->name('home');
Route::get('/products/{url}', 'ProductController@index')->name('product_url');

Route::get('/search', 'ProductController@search')->name('product_seach');
Route::get('/daily-feeds', 'ProductController@daily')->name('daily_feeds');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::post('sign-in','Auth\SignInController@sign_in')->name('signin');
Route::any('sign-in/modal','PublicController@modal_login')->name('modal_signin');
Route::post('sign-up','Auth\SignInController@signup')->name('signup');
Route::post('city','Auth\AccountController@city')->name('city_api');
Route::post('brgy','Auth\AccountController@brgy')->name('brgy_api');

Route::get('privacy-policy','PublicController@policy')->name('privacy_policy');



Route::get('/test','TestController@index');
Route::get('/test/rate','TestController@rate');
Route::get('/test/friendly','TestController@friendly_url');
Route::get('/test/brand_url','TestController@brand_url');
Route::get('/test/product_search','TestController@product_search');
Route::get('/test/address','TestController@address');
Route::get('/test/image','TestController@re_url');