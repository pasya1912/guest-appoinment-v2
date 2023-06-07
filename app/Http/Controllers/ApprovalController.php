<?php

namespace App\Http\Controllers;

use App\ApprovalHistory;
//use db
use Illuminate\Support\Facades\DB;
use App\Department;
use App\User;
use App\Checkin;
use App\FacilityDetail;
use Carbon\Carbon;
use App\Models\Appointment;
use App\RoomDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{

    public function index()
    {
        $userId = auth()->user()->id;
        $userDept = auth()->user()->department_id;
        $occupation = User::select('occupation')->where('id', $userId)->first();

        $appointments = Appointment::latest();
        //load facitily detail
        $appointments->with('facility_detail');


        if ($occupation->occupation == 2) {
            $appointments->where('pic_approval', 'approved')->where('dh_approval', 'pending')->where('pic_dept', $userDept);
        } else {
            $appointments->where('pic_approval', 'pending')->where('dh_approval', 'pending')->where('pic_id', $userId);
        }
        $appointments = $appointments->get();
        //if appointment date is tomorrow then add new key  facility_eligble false,if the day after tomorrow or later then true
        foreach ($appointments as $key => $appointment) {
            $date = Carbon::parse($appointment['date']);

            $now = Carbon::now();
            $now->setTime(0, 0, 0);
            //add 2 day
            $now->addDays(2);

            if ($date >= $now) {
                $appointments[$key]['facility_eligble'] = true;
            } else {
                $appointments[$key]['facility_eligble'] = false;
            }
        }


        return view('pages.admin.index', [
            'appointments' => $appointments,
            'occupation' => $occupation
        ]);
    }

    public function history()
    {
        $userId = auth()->user()->id;
        $userDept = auth()->user()->department_id;
        $user = User::select('occupation')->where('id', $userId)->first();

        $appointments = Appointment::latest();


        if ($user->occupation == 2) {
            $appointments->where('pic_approval', 'approved')->where('pic_dept', $userDept);
        } else {
            $appointments->where('pic_id', $userId);
        }
        // load facility_detail
        $appointments->get()->load('facility_detail');

        return view('pages.admin.history', [
            'appointments' => $appointments->get(),
            'user' => $user
        ]);
    }

    public function ticketApproval(Request $request, Appointment $ticket)
    {
        //validate request
        $user = User::select('occupation')->where('id', $ticket->pic_id)->first();
        $appointment = Appointment::where('id', $ticket->id)->first();
        if (isset($request->room)) {

            try {
                //find room detail with date time between booking time and booking end time
                $roomDetail = RoomDetail::where('room_id', $request->room)
                    ->where('booking_date', $ticket->date)
                    ->whereBetween('booking_time', [$request->time, $ticket->time_end])
                    ->orWhereBetween('booking_time_end', [$ticket->time, $ticket->time_end])->first();

                if (isset($roomDetail) && $roomDetail->appointment->pic_approval == "approved" && $roomDetail->appointment->dh_approval == 'approved') {

                    return redirect()->back()->with('error', 'Ruangan ini sudah di booking oleh '.Department::where('id', $roomDetail->appointment->pic_dept)->first()->name.' untuk tanggal ' . $ticket->date . ' pada jam ' . $roomDetail->booking_time . ' sampai ' . $roomDetail->booking_time_end . '');
                }

                $appt = Appointment::where('id', $ticket->id)->first();
                DB::beginTransaction();
                RoomDetail::updateOrCreate([
                    'appointment_id' => $appt->id
                ], [
                        'room_id' => $request->room,
                        'booking_date' => $appt->date,
                        'booking_time' => $request->time,
                        'booking_time_end' => $request->time_end
                    ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                dd($e);
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
        // if the pic of the ticket is spv down and the auth user is spv (the pic itself) then show the facility button modal
        // then only update the pic_appproval field
        if ($user->occupation == 1 && auth()->user()->occupation == 1) {
            Appointment::where('id', $ticket->id)->update([
                'pic_approval' => 'approved'
            ]);
            try {
                DB::beginTransaction();
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
                    'other' => $request->get('other-value'),
                    'appointment_id' => $ticket->id
                ]);

                // create or update approval history
                ApprovalHistory::create([
                    'signed_by' => auth()->user()->id,
                    'appointment_id' => $ticket->id,
                    'status' => 'PIC approved'
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('error', 'Something went wrong');
            }

            // if the pic of ticket is spv down (1) and the auth user is manager up, then show the approval button modal and only update the dh_approval because the pic_approval already approved, because the ticket is appear when already approved by the pic , when the ticket not approved yet by the pic, the ticket should not appear in the list
        } elseif ($user->occupation == 1 && auth()->user()->occupation == 2) {
            DB::beginTransaction();
            try{
            Appointment::where('id', $ticket->id)->update([
                'dh_approval' => 'approved'
            ]);

            // create or update approval history
            ApprovalHistory::updateOrCreate([
                'appointment_id' => $ticket->id
            ], [
                    'signed_by' => auth()->user()->id,
                    'status' => 'Dept Head approved'
                ]);
            }catch(\Exception $e){
                DB::rollback();
                dd($e);
            }

            if (isset($appointment->room_detail)) {
                try{
                    $rd = RoomDetail::leftJoin('appointments', 'room_details.appointment_id', '=', 'appointments.id')
                    ->where('booking_date', $ticket->date)
                    ->where('appointments.dh_approval', 'pending')
                    ->where(function ($query) use ($appointment) {
                        $query->where(function ($query) use ($appointment) {
                            $query->whereBetween('booking_time', [$appointment->room_detail->booking_time, $appointment->room_detail->booking_time_end]);
                        })
                        ->orWhere(function ($query) use ($appointment) {
                            $query->whereBetween('booking_time_end', [$appointment->room_detail->booking_time, $appointment->room_detail->booking_time_end]);
                        });
                    })
                    ->get();
                foreach ($rd as $r) {
                    Appointment::where('id', $r->appointment_id)->update([
                        'dh_approval' => 'rejected'
                    ]);
                    ApprovalHistory::updateOrCreate([
                        'appointment_id' => $r->appointment_id
                    ], [
                            'signed_by' => auth()->user()->id,
                            'status' => 'Waktu ruangan bentrok'
                        ]);

                    //delete corresponding room detail if the room detail is exist
                    RoomDetail::where('appointment_id', $r->appointment_id)->delete();
                }
                DB::commit();
                }catch(\Exception $e){
                    DB::rollback();
                    return redirect()->back()->with('error', $e->getMessage());
                }
            }
            //update dh_approval to rejected if room detail is not empty

            // if the pic of the ticket is manager up and the auth user is manager (the pic itself) then show the facility button modal
            // and update both pic and dh approval
        } elseif ($user->occupation == 2 && auth()->user()->occupation == 2) {

            Appointment::where('id', $ticket->id)->update([
                'pic_approval' => 'approved',
                'dh_approval' => 'approved'
            ]);


            try {
                DB::beginTransaction();
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
                    'other' => $request->get('other-value'),
                    'appointment_id' => $ticket->id
                ]);

                ApprovalHistory::create([
                    'signed_by' => auth()->user()->id,
                    'appointment_id' => $ticket->id,
                    'status' => 'Dept Head approved'
                ]);
                if (isset($appointment->room_detail)) {
                    try{
                        $rd = RoomDetail::leftJoin('appointments', 'room_details.appointment_id', '=', 'appointments.id')
                        ->where('booking_date', $ticket->date)
                        ->where('appointments.dh_approval', 'pending')
                        ->where(function ($query) use ($appointment) {
                            $query->where(function ($query) use ($appointment) {
                                $query->whereBetween('booking_time', [$appointment->room_detail->booking_time, $appointment->room_detail->booking_time_end]);
                            })
                            ->orWhere(function ($query) use ($appointment) {
                                $query->whereBetween('booking_time_end', [$appointment->room_detail->booking_time, $appointment->room_detail->booking_time_end]);
                            });
                        })
                        ->get();
                    foreach ($rd as $r) {
                        Appointment::where('id', $r->appointment_id)->update([
                            'dh_approval' => 'rejected'
                        ]);
                        ApprovalHistory::updateOrCreate([
                            'appointment_id' => $r->appointment_id
                        ], [
                                'signed_by' => auth()->user()->id,
                                'status' => 'Waktu ruangan bentrok'
                            ]);

                        //delete corresponding room detail if the room detail is exist
                        RoomDetail::where('appointment_id', $r->appointment_id)->delete();
                    }
                    DB::commit();
                    }catch(\Exception $e){
                        DB::rollback();
                        return redirect()->back()->with('error', $e->getMessage());
                    }
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('error', 'Something went wrong');
            }
        }
        //check occupancy
        if(auth()->user()->occupation <2){
            return redirect()->back()->with('approved', 'Ticket has been approved, please wait for the dept head approval!');
        }else
        {
            return redirect()->back()->with('approved', 'Ticket has been approved!');
        }
    }

    public function ticketRejection(Request $request, Appointment $ticket)
    {
        // create approval history
        $user = User::select('occupation')->where('id', $ticket->pic_id)->first();

        // if the pic of the ticket is spv down and the auth user is spv (the pic itself)
        // then only update the pic_appproval field
        if ($user->occupation == 1 && auth()->user()->occupation == 1) {
            ApprovalHistory::create([
                'signed_by' => auth()->user()->id,
                'appointment_id' => $ticket->id,
                'note' => $request->note,
                'status' => 'PIC rejected'
            ]);

            // update appointment status, if the pic reject then dept head automatically reject
            Appointment::where('id', $ticket->id)->update([
                'pic_approval' => 'rejected',
                'dh_approval' => 'rejected'
            ]);
        }
        // if the pic of ticket is spv down (1) and the auth user is manager up, then show the approval button modal and only update the dh_approval because the pic_approval already approved, because the ticket is appear when already approved by the pic , when the ticket not approved yet by the pic, the ticket should not appear in the list
        elseif ($user->occupation == 1 && auth()->user()->occupation == 2) {
            ApprovalHistory::where('appointment_id', $ticket->id)->update([
                'signed_by' => auth()->user()->id,
                'note' => $request->note,
                'status' => 'Dept Head rejected'
            ]);

            // update appointment status, if the pic reject then dept head automatically reject
            Appointment::where('id', $ticket->id)->update([
                'dh_approval' => 'rejected'
            ]);
            // if the pic of the ticket is manager up and the auth user is manager (the pic itself) then show the facility button modal
            // and update both pic and dh approval
        } elseif ($user->occupation == 2 && auth()->user()->occupation == 2) {
            ApprovalHistory::where('appointment_id', $ticket->id)->update([
                'signed_by' => auth()->user()->id,
                'note' => $request->note,
                'status' => 'Dept Head rejected'
            ]);

            // update appointment status
            Appointment::where('id', $ticket->id)->update([
                'dh_approval' => 'rejected'
            ]);
        }

        return redirect()->back()->with('reject', 'Ticket has been rejected!');
    }

    public function facilityDone(FacilityDetail $facility)
    {

        FacilityDetail::where('id', $facility->id)->update([
            'status' => 'done'
        ]);

        return redirect()->back()->with('selesai', 'Kebutuhan untuk tiket-' . $facility->appointment_id . ' telah siap!');
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
        $now = Carbon::now();
        // update checkin status
        //$appointments->time - 10 minutes

        $appointments10minutes = Carbon::parse($appointments->time)->subMinutes(10);


        if ($appointments->date >= $now->format('Y-m-d') && $appointments->time >= $now->format('H:i:s')) {
            //not allow if it's not 10 minutes before the appointment

            if ($appointments->date != $now->format('Y-m-d') && $appointments10minutes >= $now->format('H:i:s')) {
                $status = 'gagal_notyet';
            } else {
                if ($appointments !== null || $checkin_status !== null) {
                    if ($checkin_status->status === 'out') {
                        $status = "sukses_in";
                        $checkin_status->update([
                            'status' => 'in',
                            'checkin_at' => Carbon::now(),
                        ]);
                    } elseif ($checkin_status->status === 'in') {
                        $status = 'sukses_out';
                        $checkin_status->update([
                            'status' => 'out',
                            'checkout_at' => Carbon::now(),
                        ]);
                    }
                }
            }
        } else {
            $status = 'gagal_expired';
        }

        return view('pages.admin.qrcode', [
            'appointments' => $appointments,
            'qr' => $qrId,
            'status' => $status
        ]);
    }
}
