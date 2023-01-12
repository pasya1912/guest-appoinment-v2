<?php

namespace App\Http\Controllers;

use App\User;
use App\Checkin;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() 
    {
        $user_role = auth()->user()->role;
        $user_id = auth()->user()->id;
        $current_date = date("Y-m-d");

        $weekly_date = Appointment::select('start_date')->where('frequency','weekly')->get();
        $appointments = Appointment::where('status','approved')->get();
        $today_appointments = Appointment::whereIn('frequency',['daily','once','weekly'])
                                ->where('start_date', $current_date)
                                ->orWhere('end_date','>=', $current_date);
                                // get all day in the range of date
                                foreach($weekly_date as $date){
                                    $today_appointments->orWhereRaw('DAYNAME(start_date) <= DAYNAME(?)', [$date])
                                    ->orWhereRaw('DAYNAME(end_date) >= DAYNAME(?)',[$date]);
                                }
                                
        $today_appointment = $today_appointments->get();
        $visitor_inside = Checkin::where('status', 'in')->count();
        $today_visitor = $today_appointment->sum('guest');
        
        if($user_role === 'admin' || $user_role === 'approver')
        {
            return view('dashboard',[
                'appointments' => $today_appointment->where('status','approved'),
                'total_appointment' => $appointments->count(),
                'today_visitor' => $today_visitor,
                'today_appointment' => $today_appointment->where('status','approved')->count(),
                'visitor_inside' => $visitor_inside,
            ]);
        }elseif($user_role === 'visitor'){
            return view('dashboard',[
                'appointments' => $today_appointment->where('status','approved')->where('user_id',$user_id),
                'total_appointment' => $appointments->count(),
                'today_visitor' => $today_visitor,
                'today_appointment' => $today_appointment->where('user_id',$user_id)->where('status','approved')->count(),
                'visitor_inside' => $visitor_inside,
            ]);
        }
    }
}
