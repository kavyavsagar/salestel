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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'Auth\LoginController@showLoginForm');
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
    Route::resource('complaint','ComplaintController');
    
    Route::get('/ajxcustomer/{id}', 'CustomerController@getCustomer')->name('ajxcustomer');
    Route::post('order/changestatus', 'OrderController@changeStatus')->name('order.changestatus');
    Route::post('/updateOrder', 'OrderController@update')->name('order.updateOrder');
    Route::get('/ordercomplete', 'OrderController@completed')->name('order.complete');
    Route::post('complaint/changestatus', 'ComplaintController@changeStatus')->name('complaint.changestatus');    
    Route::get('/orderexport', 'OrderController@exportCSV')->name('order.exportcsv');

    Route::resource('dsr','DsrController');
    Route::get('/dsrexport', 'DsrController@exportCSV')->name('dsr.exportcsv');
    Route::post('/updateDsr', 'DsrController@update')->name('dsr.updateOrder');
});

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    // return "Cache is cleared";
    return view('cache');
})->name('cache.clear');