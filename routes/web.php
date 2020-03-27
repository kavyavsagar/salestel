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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
   
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::resource('orderstatus', 'OrderStatusController'); 
    Route::resource('pricing', 'PricingController'); 
    Route::resource('plan', 'PlanController'); 
    Route::resource('customer','CustomerController');
    Route::resource('order','OrderController');

    Route::get('/ajxcustomer/{id}', 'CustomerController@getCustomer')->name('ajxcustomer');
    Route::post('order/changestatus', 'OrderController@changeStatus')->name('order.changestatus');
    Route::post('/updateOrder', 'OrderController@update')->name('order.updateOrder');
});