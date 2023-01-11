<?php

use App\Checkin;
use App\User;
use App\Models\Appointment;
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

        $current_date = date("Y-m-d");
        
        $appointments = Appointment::where('status','approved')->get();
        $total_visitor = User::where('role', 'visitor')->count();
        $today_appointment = Appointment::whereIn('frequency',['daily','once'])
                                ->where('start_date', $current_date)
                                ->where('end_date','<=', $current_date)
                                ->count();
        $visitor_inside = Checkin::where('status', 'in')->count();
        
        return view('dashboard',[
            'appointments' => $appointments,
            'total_appointment' => $appointments->count(),
            'total_visitor' => $total_visitor,
            'today_appointment' => $today_appointment,
            'visitor_inside' => $visitor_inside,
        ]);
    })->name('dashboard');
    
    // visitor (create,history)
    Route::get('/appointment', 'AppointmentController@index')->name('appointment.index');
    Route::post('/appointment/create-ticket', 'AppointmentController@create')->name('appointment.create');
    Route::get('/appointment/history', 'AppointmentController@history')->name('appointment.history');
    
    // approver (approve, history)
    Route::get('/approval', 'ApprovalController@index')->name('ticket.index');
    Route::get('/approval/history', 'ApprovalController@history')->name('ticket.history');
    Route::post('/approval/approve/{ticket}', 'ApprovalController@ticketApproval')->name('ticket.approval');
    Route::post('/approval/reject/{ticket}', 'ApprovalController@ticketRejection')->name('ticket.rejection');

    // scanner (scan qr)
    Route::get('/qrScanView', 'ApprovalController@qrScanView')->name('qrScanView.index');
    Route::post('/qrScan', 'ApprovalController@qrScan')->name('qrScan.index');
    
    // logout
    Route::post('/logout-auth', 'Auth\LoginController@logout')->name('logout.auth');    
});