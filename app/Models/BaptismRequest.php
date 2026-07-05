<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaptismRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'location',
        'preferred_date',
        'message',
        'status',
    ];

    protected $casts = [
        'preferred_date' => 'date',
    ];

    protected $table = 'baptism_requests';
}