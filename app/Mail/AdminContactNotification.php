<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminContactNotification extends Mailable
{
    use Queueable, SerializesModels;

    public ContactMessage $message;

    public function __construct(ContactMessage $message)
    {
        $this->message = $message;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Contact Message: ' . $this->message->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.contact-notification',
            with: [
                'message' => $this->message,
                'adminName' => config('app.admin_name', 'The Collective Admin'),
            ]
        );
    }
}