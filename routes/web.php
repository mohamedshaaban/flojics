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
Route::get('/tiny', 'HomeController@tiny');
Route::get('/npm_run_watch', 'HomeController@npmRun');

Route::get('/add_slugs', 'HomeController@addSlugs');

Route::get('/internet_explorer', 'HomeController@internetExplorer');

Route::get('appointments/print_invoice/{id}', 'AppointmentController@printInvoice')->name('customer.appointment.print_invoice');


Route::group(['middleware' => 'web' ], function() {
    Route::get('/{any}', function () {
        return view('app');
    })->name('app')->where('any', '.*');

});
