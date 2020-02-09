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

// auth
Auth::routes(['register' => false]);

Route::get('logout', 'Auth\LogoutController@logout')->name('logout');

Route::get('/', 'HomeController@index');

Route::resource('categories', 'CategoryController');
Route::post('categories/update', 'CategoryController@update')->name('categories.update');
Route::get('categories/destroy/{id}', 'CategoryController@destroy');

Route::resource('products', 'ProductController');
Route::post('products/update', 'ProductController@update')->name('products.update');
Route::get('products/destroy/{id}', 'ProductController@destroy');

Route::resource('tables', 'TableController');

Route::resource('orders', 'OrderController');

Route::resource('bills', 'BillController');

Route::resource('users', 'UserController');


