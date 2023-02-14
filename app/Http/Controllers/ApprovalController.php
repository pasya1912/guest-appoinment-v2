<?php

namespace App\Http\Controllers;

use App\ApprovalHistory;
use App\User;
use App\Checkin;
use App\FacilityDetail;
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
    
    public function ticketApproval(Request $request, Appointment $ticket)
    {        
        // occupation (1)
        Appointment::where('id', $ticket->id)->update([
            'pic_approval' => 'approved'
        ]);
        
        FacilityDetail::create([
            'snack_kering' => $request->get('dry-food-quantity'),
            'snack_basah' => $request->get('wet-food-quantity'),
            'makan_siang' => $request->get('lunch-quantity'),
            'permen' => $request->get('candy-quantity'),
            'kopi' => $request->get('coffee-quantity'),
            'teh' => $request->get('tea-quantity'),
            'soft_drink' => $request->get('soft-drink-quantity'),
            'air_mineral' => $request->get('mineral-water-quantity'),
            'helm' => $request->get('helm-quantity'),
            'handuk' => $request->get('handuk-quantity'),
            'speaker' => $request->get('speaker-quantity'),
            'speaker_wireless' => $request->get('speaker-wireless-quantity'),
            'mobil' => $request->get('mobil-quantity'),
            'motor' => $request->get('motor-quantity'),
            'mini_bus' => $request->get('mini-bus-quantity'),
            'bus' => $request->get('bus-quantity'),
            'appointment_id' => $ticket->id
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