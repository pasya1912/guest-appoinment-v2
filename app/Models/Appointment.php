<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    protected $fillable = [
        'name',
        'purpose',
        'frequency',
        'date',
        'time',
        'guest',
        'pic',
        'dept',
        'doc',
        'selfie',
        'status'
    ];
}
