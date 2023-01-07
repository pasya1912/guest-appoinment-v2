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

// default route
Route::get('/', function () {
    return view('pages.user-pages.login');
})->middleware(['guest']);

Route::post('/logout-auth', 'Auth\LoginController@logout')->name('logout.auth');

// guest route
Route::middleware(['guest'])->group(function () {
    
    Route::get('/register', 'Auth\RegisterController@index')->name('register.index');
    Route::post('/register-store', 'Auth\RegisterController@store')->name('register.store');

    
    Route::get('/login', 'Auth\LoginController@index')->name('login');
    Route::post('/login-auth', 'Auth\LoginController@authenticate')->name('login.auth');
});

// auth route
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/appointment', 'AppointmentController@index')->name('appointment.index');
    Route::post('/appointment/create-ticket', 'AppointmentController@create')->name('appointment.create');
    Route::get('/appointment/history', 'AppointmentController@history')->name('appointment.history');
    Route::get('/appointment/appointment-ticket', 'AppointmentController@ticket')->name('ticket.index');
    Route::post('/appointment/approval/{ticket}', 'AppointmentController@ticketApproval')->name('ticket.approval');
    Route::post('/appointment/rejection/{ticket}', 'AppointmentController@ticketRejection')->name('ticket.rejection');
    
    Route::post('/logout-auth', 'Auth\LoginController@logout')->name('logout.auth');

    Route::get('/scanQr', function(){
        return view('pages.admin.qrcode');
    });

});