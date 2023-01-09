<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Appointment::select('name', 'purpose'.'frequency','date', 'guest', 'pic', 'dept');
            return \Yajra\DataTables\Facades\DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('pages.visitor.index');
    }

    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'frekuensi' => 'required',
            'purpose-1' => 'required_without_all:purpose-2,purpose-3',
            'purpose-2' => 'required_without_all:purpose-1,purpose-3',
            'purpose-3' => 'required_without_all:purpose-1,purpose-2',
            'start_date' => 'required',
            'end_date' => 'required',
            'time' => 'required',
            'jumlahTamu' => 'required',
            'pic' => 'required',
            'dept' => 'required',
        ]);

        $purpose = '';
        if($request->has('purpose-1')) {
            $purpose .= 'isi dari purpose-1, ';
        }
        if($request->has('purpose-2')) {
            $purpose .= 'isi dari purpose-2, ';
        }
        if($request->has('purpose-3')) {
            $purpose .= 'isi dari purpose-3, ';
        }
        $purpose = rtrim($purpose, ', ');

        if($request->has('doc')){
            $doc = $request->file('doc');
            $docName = time() . '-' . $doc->getClientOriginalName();
            $doc->move(public_path('uploads/doc'), $docName);
        } else {
            $docName = '';
        }

        if($request->has('selfie')){
            $doc2 = $request->file('selfie');
            $doc2Name = time() . '-' . $doc2->getClientOriginalName();
            $doc2->move(public_path('uploads/selfie'), $doc2Name);
        } else {
            $doc2Name = '';
        }

        Appointment::create([
            'name' => $request->nama,
            'purpose' => $purpose,
            'frequency' => $request->frekuensi,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'date' => $request->date,
            'time' => $request->time,
            'guest' => $request->jumlahTamu,
            'pic' => $request->pic,
            'dept' => $request->dept,
            'doc' => $docName,
            'selfie' => $doc2Name,
            'status' => 'pending',
            'user_id' => auth()->user()->id
        ]);
        
        return redirect()->route('appointment.history')->with('success', 'Your ticket has been successfully created!');
    }
    
    public function history()
    {
        if(auth()->user()->role === 'visitor')
        {
            $appointments = Appointment::latest()->where('user_id', auth()->user()->id)->paginate(8);
    
            return view('pages.visitor.history',[
                'appointments' => $appointments,
            ]);
        }

        $appointments = Appointment::latest()->paginate(8);
        
        return view('pages.admin.history',[
            'appointments' => $appointments,
        ]);
        
    }

    public function ticket()
    {
        $appointments = Appointment::latest()
                                ->where('status','pending')
                                ->paginate(8);
        
        return view('pages.admin.index',[
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

        return view('pages.admin.qrcode',[
            'appointments' => $appointments,
        ]);
    }
}