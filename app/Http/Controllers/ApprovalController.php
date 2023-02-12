<?php

namespace App\Http\Controllers;

use App\ApprovalHistory;
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
        $userId = auth()->user()->id;

        $appointments = Appointment::latest()
                                ->where('pic_approval','pending')
                                ->where('dh_approval','pending')
                                ->where('pic_id',$userId)
                                ->get();
        
        return view('pages.admin.index',[
            'appointments' => $appointments,
        ]);
    }

    public function history()
    {
        $userId = auth()->user()->id;
        $appointments = Appointment::latest()
                                ->where('pic_id',$userId)
                                ->get();
        
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
    
    public function ticketRejection(Request $request, Appointment $ticket)
    {
        // create approval history
        ApprovalHistory::create([
            'signed_by' => auth()->user()->id,
            'appointment_id' =>  $ticket->id,
            'note' => $request->note,
            'status' => 'rejected'
        ]);

        // update appointment status
        Appointment::where('id', $ticket->id)->update([
            'pic_approval' => 'rejected'
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

        // update checkin status
        if($appointments !== null || $checkin_status !== null){
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
        }
        
        return view('pages.admin.qrcode',[
            'appointments' => $appointments,
            'status' => $checkin_status,
            'qr' => $qrId
        ]);
    }
}