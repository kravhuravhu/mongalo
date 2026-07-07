<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventRegistration;
use Carbon\Carbon;

class GoogleCalendarService
{
    /**
     * Generate a Google Calendar link for the event
     */
    public function generateEventLink(Event $event, EventRegistration $registrant): string
    {
        $start = Carbon::parse($event->date . ' ' . $event->time);
        $end = $start->copy()->addHours(2);

        $params = [
            'action' => 'TEMPLATE',
            'text' => $event->title,
            'dates' => $start->format('Ymd\THis') . '/' . $end->format('Ymd\THis'),
            'details' => $event->description ?? 'Join us for this event.',
            'location' => $event->location,
            'trp' => 'false',
            'sprop' => 'name:thecollective.co.za',
        ];

        return 'https://calendar.google.com/calendar/render?' . http_build_query($params);
    }

    /**
     * Generate an ICS file content for the event
     */
    public function generateICS(Event $event, EventRegistration $registrant): string
    {
        $start = Carbon::parse($event->date . ' ' . $event->time);
        $end = $start->copy()->addHours(2);

        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//The Collective//Events//EN\r\n";
        $ics .= "CALSCALE:GREGORIAN\r\n";
        $ics .= "METHOD:PUBLISH\r\n";
        $ics .= "BEGIN:VEVENT\r\n";
        $ics .= "UID:" . uniqid() . "@thecollective.co.za\r\n";
        $ics .= "DTSTAMP:" . now()->format('Ymd\THis') . "\r\n";
        $ics .= "DTSTART:" . $start->format('Ymd\THis') . "\r\n";
        $ics .= "DTEND:" . $end->format('Ymd\THis') . "\r\n";
        $ics .= "SUMMARY:" . $this->escapeText($event->title) . "\r\n";
        $ics .= "DESCRIPTION:" . $this->escapeText($event->description ?? 'Join us for this event.') . "\r\n";
        $ics .= "LOCATION:" . $this->escapeText($event->location) . "\r\n";
        $ics .= "ORGANIZER:mailto:hello@thecollective.co.za\r\n";
        $ics .= "ATTENDEE;CN=" . $this->escapeText($registrant->name) . ":mailto:" . $registrant->email . "\r\n";
        $ics .= "STATUS:CONFIRMED\r\n";
        $ics .= "END:VEVENT\r\n";
        $ics .= "END:VCALENDAR\r\n";

        return $ics;
    }

    /**
     * Escape text for ICS format
     */
    private function escapeText(string $text): string
    {
        $text = str_replace(["\r\n", "\n", "\r"], '\\n', $text);
        $text = str_replace([',', ';', '\\'], ['\,', '\;', '\\\\'], $text);
        return $text;
    }

    /**
     * Generate a simple calendar link (fallback)
     */
    public function generateCalendarLink(Event $event): string
    {
        $start = Carbon::parse($event->date . ' ' . $event->time);
        $end = $start->copy()->addHours(2);

        return sprintf(
            'https://www.google.com/calendar/render?action=TEMPLATE&text=%s&dates=%s/%s&details=%s&location=%s',
            urlencode($event->title),
            $start->format('Ymd\THis'),
            $end->format('Ymd\THis'),
            urlencode($event->description ?? 'Join us for this event.'),
            urlencode($event->location)
        );
    }
}