<?php

namespace App\Mail;

use App\Models\BaptismRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminBaptismNotification extends Mailable
{
    use Queueable, SerializesModels;

    public BaptismRequest $baptism;

    public function __construct(BaptismRequest $baptism)
    {
        $this->baptism = $baptism;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Baptism Request from ' . $this->baptism->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.baptism-notification',
            with: [
                'baptism' => $this->baptism,
                'adminName' => config('app.admin_name', 'The Collective Admin'),
            ]
        );
    }
}