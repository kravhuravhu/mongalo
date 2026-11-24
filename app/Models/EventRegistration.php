<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_id',
        'occurrence_date',
        'name',
        'email',
        'phone',
        'registration_id',
        'payment_status',
    ];

    protected $casts = [
        'occurrence_date' => 'date',
    ];

    protected $table = 'event_registrations';

    // ─── RELATIONSHIP ───
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public static function generateRegistrationId()
    {
        return 'RE' . date('Y') . '-' . strtoupper(uniqid());
    }
}