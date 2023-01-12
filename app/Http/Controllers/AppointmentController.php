<?php

namespace App\Http\Controllers;

use App\Checkin;
use App\Department;
use App\Exports\ExportTicket;
use App\Models\Appointment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AppointmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();

        return view('pages.visitor.index',[
            'departments' => $departments,
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'frekuensi' => 'required',
            'purpose-1' => 'required_without_all:purpose-2,purpose-3,purpose-4',
            'purpose-2' => 'required_without_all:purpose-1,purpose-3,purpose-4',
            'purpose-3' => 'required_without_all:purpose-1,purpose-2,purpose-4',
            'purpose-4' => 'required_without_all:purpose-1,purpose-2,purpose-3',
            'start_date' => 'required',
            'end_date' => 'required',
            'time' => 'required',
            'jumlahTamu' => 'required',
            'pic' => 'required',
            'pic_dept' => 'required',
        ]);

        $purpose = '';
        if($request->has('purpose-1')) {
            $purpose .= 'Company Visit, ';
        }
        if($request->has('purpose-2')) {
            $purpose .= 'Benchmarking, ';
        }
        if($request->has('purpose-3')) {
            $purpose .= 'Trial ';
        }
        if($request->has('purpose-4')) {
            $purpose .= $request->other_purpose;
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

        $appointment = Appointment::create([
            'name' => $request->nama,
            'purpose' => $purpose,
            'frequency' => $request->frekuensi,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'time' => $request->time,
            'guest' => $request->jumlahTamu,
            'pic' => $request->pic,
            'pic_dept' => $request->pic_dept,
            'doc' => $docName,
            'selfie' => $doc2Name,
            'status' => 'pending',
            'user_id' => auth()->user()->id
        ]);

        // create checkin data immedietly
        Checkin::create([
            'appointment_id' => $appointment->id,
            'status' => 'out',
        ]);
        
        return redirect()->route('appointment.history')->with('success', 'Your ticket has been successfully created! Please wait for the PIC to approve your ticket or Contact the PIC');
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
        
    }

    public function getPic(Request $request)
    {
        // get all pic where dept_id is dept
        $pic = User::where('department_id', $request->dept)->get();

        return $pic;
    }

    public function export()
    {
        // export ticket
        return Excel::download(new ExportTicket, 'appointment.xlsx');
    }
}