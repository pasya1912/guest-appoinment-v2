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

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/appointment', 'AppointmentController@index')->name('appointment.index');
Route::post('/appointment-create', 'AppointmentController@create')->name('appointment.create');
Route::get('/appointment-history', 'AppointmentController@history')->name('appointment.history');
