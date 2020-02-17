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

Auth::routes(['register' => false]);
Route::get('logout', 'Auth\LogoutController@logout')->name('logout');
Route::get('/', 'HomeController@index')->name('index')->middleware('auth');

Route::middleware('auth')->group(function () {
    // Categories
    Route::group(['prefix' => '/categories'], function () {
        Route::get('', 'CategoryController@index')->name('categories.index')->middleware('can:view-categories');
        Route::post('', 'CategoryController@store')->name('categories.store')->middleware('can:create-categories');
        Route::get('/{id}/edit', 'CategoryController@edit')->middleware('can:update-categories');
        Route::post('/update',
            'CategoryController@update')->name('categories.update')->middleware('can:update-categories');
        Route::get('/destroy/{id}', 'CategoryController@destroy')->middleware('can:delete-categories');
    });

    // Products
    Route::group(['prefix' => '/products'], function () {
        Route::get('', 'ProductController@index')->name('products.index')->middleware('can:view-products');
        Route::post('', 'ProductController@store')->name('products.store')->middleware('can:create-products');
        Route::get('/{id}/edit', 'ProductController@edit')->middleware('can:update-products');
        Route::post('/update', 'ProductController@update')->name('products.update')->middleware('can:update-products');
        Route::get('/destroy/{id}', 'ProductController@destroy')->middleware('can:delete-products');
    });

    // Tables
    Route::group(['prefix' => '/tables'], function () {
        Route::get('', 'TableController@index')->name('tables.index')->middleware('can:view-tables');
        Route::post('', 'TableController@store')->name('tables.store')->middleware('can:create-tables');
        Route::get('/{id}/edit', 'TableController@edit')->middleware('can:update-tables');
        Route::post('/update', 'TableController@update')->name('tables.update')->middleware('can:update-tables');
        Route::get('/destroy/{id}', 'TableController@destroy')->middleware('can:delete-tables');
    });

    // Users
    Route::group(['prefix' => '/users'], function () {
        Route::get('', 'UserController@index')->name('users.index')->middleware('can:view-users');
        Route::post('', 'UserController@store')->name('users.store')->middleware('can:create-users');
        Route::get('/{id}/edit', 'UserController@edit')->middleware('can:update-users');
        Route::post('/update', 'UserController@update')->name('users.update')->middleware('can:update-users');
        Route::get('/destroy/{id}', 'UserController@destroy')->middleware('can:delete-users');
    });

    // Order
    Route::group(['prefix' => '/orders'], function () {
        Route::get('', 'OrderController@index')->name('orders.index')->middleware('can:view-orders');
        Route::post('', 'OrderController@store')->name('orders.store')->middleware('can:create-orders');
        Route::get('/{id}/edit', 'OrderController@edit')->middleware('can:update-orders');
        Route::post('/update', 'OrderController@update')->name('orders.update')->middleware('can:update-orders');
        Route::get('/destroy/{id}', 'OrderController@destroy')->middleware('can:delete-orders');
    });
});





