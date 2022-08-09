<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

Route::middleware('auth:api')->group(function () {
    Route::post('appointments',  'AppointmentController@appointments');
    Route::post('delappointments',  'AppointmentController@delappointments');
    Route::post('logout',  'AuthController@logout');
    Route::post('updateprofile', 'AuthController@updateprofile');

});
Route::group(['middleware' => 'web' ], function() {

     Route::get('header-menus', 'MenuController@headerMenus');
    Route::get('footer-menus', 'MenuController@footerMenus');

    Route::get('home-departments', 'DepartmentController@homeDepartments');
    Route::get('home-doctors', 'DoctorController@homeDoctors');
    Route::get('departments', 'DepartmentController@getAll');
    Route::get('apptdepartments', 'DepartmentController@getApptAll');
    Route::get('list-departments', 'DepartmentController@getAllFilterDepartment');
    Route::get('filter-departments/{id}', 'DepartmentController@getFilterDepartment');
    Route::get('departments/{id}', 'DepartmentController@getDepartmentDetails');
    Route::get('department-doctors/{id}', 'DoctorController@getDepartmentDoctors');
    Route::get('appoiment-department-doctors/{id}', 'DoctorController@getDepartmentDoctorsForAppoitmnet');
    Route::get('appoiment-department-confirm-doctors/{id}', 'DoctorController@getDepartmentDoctorsForConformationAppoitmnet');
    Route::get('departments-doctors/{id}', 'DoctorController@getDepartmentsDoctors');
    Route::get('dedoctorsdetails/{id}', 'DoctorController@getDoctorsInfo');
    Route::get('doctors', 'DoctorController@getAll');
    Route::get('doctors_departments', 'DoctorController@getDoctors');
    Route::get('filter-doctors/{filter}', 'DoctorController@getFilterDoctors');
    Route::get('letter-doctors/{letter}', 'DoctorController@getLetterDoctors');
    Route::get('name-doctors/{name}', 'DoctorController@getNameDoctors');
    Route::get('doctors/{id}', 'DoctorController@getDoctorDetails');

    Route::get('department-phones', 'DepartmentController@getDepartmentPhones');
    Route::post('appointment/getAvaliableTime', 'AppointmentController@getAvaliableTime');
    Route::get('appointment/confirmation/{id}', 'AppointmentController@getConfirmation');
    Route::post('appointment/delete', 'AppointmentController@deleteAppointment');
    Route::post('appointment/reserveBookingSlot', 'AppointmentController@reserveBookingSlot');
    Route::post('appointment/store', 'AppointmentController@store');
    Route::get('lang/{locale}', 'HomeController@switchLang');
    Route::get('appt_decleartions', 'AppointmentController@getDecleartions');
    Route::get('cancel_appt_decleartions', 'AppointmentController@getCancelDecleartions');

    Route::get('register/resendotp', 'AuthController@resendotp');
    Route::post('register/checkotp', 'AuthController@checkotp');


    Route::get('update/resendotp', 'AuthController@resendupdateotp');
    Route::post('update/checkotp', 'AuthController@checkupdateotp');
    Route::post('resetlink', 'AuthController@resetlink');
    Route::post('setpassword', 'AuthController@setPassword');


});
