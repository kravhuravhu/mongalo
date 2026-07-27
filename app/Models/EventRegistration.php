<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'email',
        'phone',
        'registration_id',
        'payment_status',
    ];

    protected $table = 'event_registrations';

    // ─── RELATIONSHIP ───
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public static function generateRegistrationId()
    {
        return 'REG-' . date('Y') . '-' . strtoupper(uniqid());
    }
}