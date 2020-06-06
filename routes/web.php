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
    Route::get('/updateplan', 'OrderController@updatePlan')->name('order.updateplan');
    Route::post('/saveplan', 'OrderController@savePlan')->name('order.saveplan');
    

    Route::resource('dsr','DsrController');
    Route::get('/dsrexport', 'DsrController@exportCSV')->name('dsr.exportcsv');
    Route::post('/updateDsr', 'DsrController@update')->name('dsr.updateOrder');
    Route::post('/activateDsr', 'DsrController@changeStatus')->name('dsr.changestatus');

    Route::get('/customerimport', 'CustomerController@importView')->name('customer.importview');
    Route::get('/customerpending', 'CustomerController@pending')->name('customer.pending');
    Route::post('/importExl', 'CustomerController@importExl')->name('customer.importExl');
    Route::post('/importRetention', 'CustomerController@importRetention')->name('customer.importRetention');

    Route::post('/fetchcustomer', 'CustomerController@fetchCustomer')->name('customer.fetch');

    Route::get('/createmeeting', 'MeetingController@index')->name('meeting.index');
    Route::post('/meeting/host', 'MeetingController@host')->name('meeting.host');    
});

Route::get('/meeting/{id}', 'MeetingController@start')->name('meeting.start');
Route::get('/joinmeeting', 'MeetingController@join')->name('meeting.join');
Route::post('/meeting/join', 'MeetingController@joined')->name('meeting.joined');

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    // return "Cache is cleared";
    return view('cache');
})->name('cache.clear');