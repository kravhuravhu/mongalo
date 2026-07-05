<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventRegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $event;
    public $icsContent;

    public function __construct(EventRegistration $registration, Event $event, $icsContent)
    {
        $this->registration = $registration;
        $this->event = $event;
        $this->icsContent = $icsContent;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Event Registration Confirmation - ' . $this->event->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.event-registration',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->icsContent, 'event.ics')
                ->withMime('text/calendar'),
        ];
    }
}