<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventRegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public EventRegistration $registration;
    public Event $event;

    public function __construct(EventRegistration $registration, Event $event)
    {
        $this->registration = $registration;
        $this->event = $event;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration Confirmation: ' . $this->event->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.event-registration',
            with: [
                'registration' => $this->registration,
                'event' => $this->event,
                'isFree' => $this->event->is_free,
                'bankingDetails' => $this->event->is_free ? null : [
                    'bank' => config('app.bank_name', 'Nedbank'),
                    'account_name' => config('app.bank_account_name', 'The Collective'),
                    'account_number' => config('app.bank_account_number', '1234567890'),
                    'branch_code' => config('app.bank_branch_code', '198765'),
                    'reference' => $this->registration->registration_id,
                ],
            ]
        );
    }
}