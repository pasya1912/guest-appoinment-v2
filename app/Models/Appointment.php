<?php

namespace App\Models;

use App\Checkin;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    protected $guarded = ['id'];

    // one to many (inverse) relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function checkin()
    {
        return $this->hasOne(Checkin::class);
    }
}
