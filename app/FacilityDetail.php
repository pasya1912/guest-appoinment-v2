<?php

namespace App;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;

class FacilityDetail extends Model
{
    protected $table = 'facility_details';

    protected $guarded = ['id'];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
