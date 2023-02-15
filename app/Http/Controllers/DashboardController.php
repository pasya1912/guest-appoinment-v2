<?php

namespace App\Http\Controllers;

use App\User;
use App\Checkin;
use App\FacilityDetail;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() 
    {
        $user_role = auth()->user()->role;
        $user_id = auth()->user()->id;
        $user_dept = auth()->user()->department_id;
        $current_date = date("Y-m-d");

        $appointments = Appointment::where('pic_approval','approved')->where('dh_approval','approved')->get();
        $today_appointments = Appointment::where('date', $current_date);

        $today_appointment = $today_appointments->get();
        $visitor_inside = Checkin::with('appointment')
                        ->join('appointments', 'appointments.id', '=', 'checkin.appointment_id')
                        ->where('date', $current_date)
                        ->where('checkin.status', 'in')->count();
        $today_visitor = $today_appointment->sum('guest');

        $facilities = DB::table('facility_details')->join('appointments', 'appointments.id', '=', 'facility_details.appointment_id')
                            ->where('pic_approval','approved')
                            ->where('dh_approval','approved')
                            ->where('status','pending')
                            ->get();

        if($user_role === 'admin'){
            return view('dashboard',[
                'appointments' => $today_appointment->where('pic_approval','approved')->where('dh_approval','approved'),
                'total_appointment' => $appointments->count(),
                'today_visitor' => $today_visitor,
                'today_appointment' => $today_appointment->where('pic_status','approved')->where('dh_approval','approved')->count(),
                'visitor_inside' => $visitor_inside,
            ]);
        }elseif($user_role === 'approver'){
            return view('dashboard',[
                // showing appointment by department
                'appointments' => $today_appointment->where('pic_approval','approved')->where('dh_approval','approved')->where('pic_dept', $user_dept),
                'total_appointment' => $appointments->count(),
                'today_visitor' => $today_visitor,
                'today_appointment' => $today_appointment->where('pic_approval','approved')->where('dh_approval','approved')->count(),
                'visitor_inside' => $visitor_inside,
            ]);
        }elseif($user_role === 'visitor'){
            return view('dashboard',[
                'appointments' => $today_appointment->where('pic_approval','approved')->where('dh_approval','approved')->where('user_id',$user_id),
                'total_appointment' => $appointments->count(),
                'today_visitor' => $today_visitor,
                'today_appointment' => $today_appointment->where('user_id',$user_id)->where('pic_approval','approved')->where('dh_approval','approved')->count(),
                'visitor_inside' => $visitor_inside,
            ]);
        }else{
            return view('dashboard',[
                'facilities' => $facilities
            ]);
        }
    }
}