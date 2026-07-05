<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InviteRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'event_name',
        'event_date',
        'location',
        'expected_attendance',
        'message',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    protected $table = 'invite_requests';
}