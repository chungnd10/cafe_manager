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

Route::get('logout', 'Auth\LogoutController@logout')
    ->name('logout');

Route::get('/', 'HomeController@index');

Route::prefix('category')->group(function () {
    Route::get('', 'CategoryController@index')
        ->middleware('can:view-category')
        ->name('category');
});

Route::prefix('product')->group(function () {
    Route::get('', 'ProductController@index')
        ->middleware('can:view-product')
        ->name('product');
});

Route::prefix('table')->group(function () {
    Route::get('', 'TableController@index')
        ->middleware('can:view-table')
        ->name('table');
});

Route::prefix('order')->group(function () {
    Route::get('', 'OrderController@index')
        ->middleware('can:view-order')
        ->name('order');
});

Route::prefix('bill')->group(function () {
    Route::get('', 'BillController@index')
        ->middleware('can:view-bill')
        ->name('bill');
});

Route::prefix('user')->group(function () {
    Route::get('', 'UserController@index')
        ->middleware('can:view-user')
        ->name('user');
});
