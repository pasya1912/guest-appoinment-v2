<?php

namespace App\Models;

use App\User;
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
        'status',
        'user_id'
    ];

    // one to many (inverse) relation
    public function user()
    {
        $this->belongsTo(User::class);
    }
}
