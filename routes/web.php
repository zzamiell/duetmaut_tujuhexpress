<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('home');
    });
    Route::resource('user', 'UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
    Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});
//------------------------ROUTE ORDERS-------------------------------------
Route::group(['middleware' => 'auth'], function () {
    //--------------------index---------------------------------
    Route::get('orders/index', 'OrdersController@index')->name('orders.index');
    //--------------------exportCSV---------------------------------
    Route::get('orders/index/export/', 'OrdersController@export')->name('orders.export');
    //--------------------create Import Order---------------------------------
    Route::post('orders/index/import', 'OrdersController@import')->name('orders.import');
    //--------------------mass update import---------------------------------
    Route::post('orders/index/importupdate', 'OrdersController@importUpdate')->name('orders.importupdate');

    //--------------------create----------------------------------------------
    Route::get('orders/create', 'OrdersController@create')->name('orders.create');
    //--------------------createStore----------------------------------------------
    Route::post('orders/index', 'OrdersController@store')->name('orders.store');
    //--------------------Show----------------------------------------------
    Route::get('orders/show/{id}/{awb}', 'OrdersController@show')->name('orders.show');
    //--------------------Update----------------------------------------------
    Route::post('orders/show/{awb}', 'OrdersController@update')->name('orders.update');
    Route::post('orders/update/{id}', 'OrdersController@update_order')->name('update');
    //--------------------Filter------------------------
    Route::get('orders/filter', 'OrdersController@filter')->name('orders.filter');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('home');
    });
    Route::get('users/index', 'UserController@index')->name('users.index');
    Route::get('users/index', 'UserController@create')->name('users.create');
    Route::post('users/index', 'UserController@store')->name('users.store');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('home');
    });

    Route::get('clients/index', 'ClientsController@index')->name('clients.index');
    Route::get('clients/index/{id}', 'ClientsController@show')->name('client_show');
    Route::post('insert_client', 'ClientsController@insert_client')->name('insert_client');
    Route::post('update_client/{id}', 'ClientsController@update_client')->name('update_client');
    Route::post('hapus_clients/{id}', 'ClientsController@hapus_clients')->name('hapus_clients');

    Route::get('pricing/index', 'PricingController@index')->name('pricing/index');
    Route::get('add_pricing/{id}', 'ClientsController@add_pricing')->name('add_pricing');
    Route::post('insert_pricing', 'ClientsController@insert_pricing')->name('insert_pricing');
});
