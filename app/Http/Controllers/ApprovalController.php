<?php

namespace App\Http\Controllers;

use App\User;
use App\Checkin;
use Carbon\Carbon;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    
    public function index()
    {
        $user_dept_id = auth()->user()->department_id;

        $appointments = Appointment::latest()
                                ->where('status','pending')
                                ->where('pic_dept',$user_dept_id)
                                ->paginate(8);
        
        return view('pages.admin.index',[
            'appointments' => $appointments,
        ]);
    }

    public function history()
    {
        $user_dept_id = auth()->user()->department_id;
        $appointments = Appointment::latest()
                                ->where('pic_dept',$user_dept_id)
                                ->paginate(8);
        
        return view('pages.admin.history',[
            'appointments' => $appointments,
        ]);
        
    }
    
    public function ticketApproval(Appointment $ticket)
    {
        Appointment::where('id', $ticket->id)->update([
            'status' => 'approved'
        ]);
        
        return redirect()->back()->with('approved','Ticket has been approved!');
    }
    
    public function ticketRejection(Appointment $ticket)
    {
        Appointment::where('id', $ticket->id)->update([
            'status' => 'rejected'
        ]);
        
        return redirect()->back()->with('reject','Ticket has been rejected!');
    }

    public function qrScanView()
    {
        return view('pages.admin.qrcode', [
            'appointments' => [],
        ]);
    }
    
    public function qrScan(Request $request)
    {
        $qrId = $request->qrcode;
        $appointments = Appointment::where('id', $qrId)->first();

        // get checkin status
        $checkin_status = Checkin::where('appointment_id', $qrId)->first();
        // dd($checkin_status->status);

        // update checkin status
        if($checkin_status->status === 'out'){
            $checkin_status->update([
                'status' => 'in',
                'checkin_at' => Carbon::now(),
            ]);
        }elseif($checkin_status->status === 'in'){
            $checkin_status->update([
                'status' => 'out',
                'checkout_at' => Carbon::now(),
            ]);
        }
        
        return view('pages.admin.qrcode',[
            'appointments' => $appointments,
            'status' => $checkin_status,
        ]);
    }
}
