<?php

use Illuminate\Routing\Router;

Admin::routes();
\App::setLocale('en');
Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->resource('departments', DepartmentController::class);

    $router->resource('doctors', DoctorController::class);
      $router->get('appointments', '\App\Admin\Controllers\AppointmentController@index')->name('admin_appointments.index');
    $router->get('appointments/create', '\App\Admin\Controllers\AppointmentController@create');
    $router->POST('appointments', '\App\Admin\Controllers\AppointmentController@store');
    $router->get('appointments/{id}/edit', '\App\Admin\Controllers\AppointmentController@edit');
    $router->PUT('appointments/{id}', '\App\Admin\Controllers\AppointmentController@update');
    $router->get('appointments/{id}', '\App\Admin\Controllers\AppointmentController@show');
    $router->DELETE('appointments/{id}', '\App\Admin\Controllers\AppointmentController@destroy');


});
