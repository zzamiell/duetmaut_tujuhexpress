<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AccessController;

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
Route::post('login1', ['as' => 'login1', 'uses' => 'AuthController@LoginThroughBackend']);


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
    Route::get('orders/index/export/{page}/{tglawal}/{tglakhir}/{status}/{account_name}', 'OrdersController@export')->name('orders.export');
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

    // proses in create order
    Route::get('/serviceByaccount/{id}', 'OrdersController@service_order_by_account')->name('serviceByaccount');
    Route::get('/kode_zip/{service}/{id}', 'OrdersController@load_postal_code')->name('load_postalCode');
    Route::get('/shipper_detail/{postalcode}', 'OrdersController@shipper_detail')->name('shipper_detail');
    Route::get('/recipt_detail/{postalcode}', 'OrdersController@recipt_detail')->name('recipt_detail');
    Route::get('/cod_fee/{idclient}', 'OrdersController@is_cod')->name('cod_fee');
    Route::get('/insured_fee/{idclient}', 'OrdersController@is_insured')->name('insured_fee');
    Route::get('/get_pricing/{idpricing}', 'OrdersController@ambil_pricing')->name('get_pricing');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('home');
    });
    Route::get('users/index', 'UserController@index')->name('users.index');
    Route::get('users/index', 'UserController@create')->name('users.create');
    Route::post('users/index', 'UserController@store')->name('users.store');
    Route::post('insert_user', 'UserController@insert_user')->name('insert_user');
    Route::post('update_user', 'UserController@update_user')->name('update_user');
    Route::post('delete_user', 'UserController@delete_user')->name('delete_user');
    Route::get('users/checked_user', 'UserController@checked_user')->name('checked_user');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('home');
    });

    Route::get('clients/index', 'ClientsController@index')->name('clients.index');
    Route::get('clients/index/{id}/{service}', 'ClientsController@show')->name('client_show');
    Route::post('insert_client', 'ClientsController@insert_client')->name('insert_client');
    Route::post('update_client/{id}', 'ClientsController@update_client')->name('update_client');
    Route::post('hapus_clients/{id}', 'ClientsController@hapus_clients')->name('hapus_clients');

    Route::get('pricing/index', 'PricingController@index')->name('pricing/index');
    Route::get('add_pricing/{id}', 'ClientsController@add_pricing')->name('add_pricing');
    Route::post('insert_pricing', 'ClientsController@insert_pricing')->name('insert_pricing');
    Route::get('pricing/index/export/{page}/{id}', 'ClientsController@exportPricing')->name('pricing.export');
    Route::post('importExcelTbPricing', ['as' => 'importExcelTbPricing', 'uses' => 'ClientsController@importExcel']);

    // Role Management
    Route::get('/role/user-role', 'RoleController@index')->name('role.index');
    Route::post('/role/add-user-role', 'RoleController@insert_role')->name('role.store');
    Route::post('/role/delete-user-role/{id}', 'RoleController@delete_role')->name('role.delete');
    Route::post('/role/update-user-role', 'RoleController@update_role')->name('role.update');

    // Menu managment
    Route::get('/menu/index', 'MenuController@index')->name('menu.index');
    Route::post('/menu/store', 'MenuController@store')->name('menu.store');
    Route::post('/menu/update', 'MenuController@update')->name('menu.update');
    Route::post('/menu/delete-menu/{id}', 'MenuController@delete')->name('menu.delete');

    // Akses Menu User Role
    Route::get('/access/{id}', 'AccessController@index')->name('access.index');
    Route::post('/access/store', 'AccessController@store')->name('access.store');
    Route::post('/access/delete/{id}', 'AccessController@delete')->name('access.delete');
});
