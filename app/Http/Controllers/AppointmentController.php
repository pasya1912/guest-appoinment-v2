<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use BaconQrCode\Encoder\QrCode;

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

        return view('pages.appointment.index');
    }

    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'frekuensi' => 'required',
            'purpose-1' => 'required_without_all:purpose-2,purpose-3',
            'purpose-2' => 'required_without_all:purpose-1,purpose-3',
            'purpose-3' => 'required_without_all:purpose-1,purpose-2',
            'date' => 'required',
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
            'date' => $request->date,
            'time' => $request->time,
            'guest' => $request->jumlahTamu,
            'pic' => $request->pic,
            'dept' => $request->dept,
            'doc' => $docName,
            'selfie' => $doc2Name,
            'status' => 'pending'
        ]);
        
        return redirect()->route('appointment.history');
    }
    
    public function history()
    {
        return view('pages.appointment.history');
    }
}
