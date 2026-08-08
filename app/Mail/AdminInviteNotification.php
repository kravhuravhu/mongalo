<?php

namespace App\Mail;

use App\Models\InviteRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminInviteNotification extends Mailable
{
    use Queueable, SerializesModels;

    public InviteRequest $invite;

    public function __construct(InviteRequest $invite)
    {
        $this->invite = $invite;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Invite Request from ' . $this->invite->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.invite-notification',
            with: [
                'invite' => $this->invite,
                'adminName' => config('app.admin_name', 'The Collective Admin'),
            ]
        );
    }
}