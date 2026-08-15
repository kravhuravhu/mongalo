<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;
use App\Services\AdminNotificationService;
use App\Services\PhoneService;

class ContactController extends Controller
{
    protected PhoneService $phoneService;

    protected AdminNotificationService $notificationService;

    public function __construct(
        PhoneService $phoneService,
        AdminNotificationService $notificationService
    ) {
        $this->phoneService = $phoneService;
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        return view('public.contact.index');
    }

    public function send(ContactRequest $request)
    {
        $validated = $request->validated();

        if (!empty($validated['phone'])) {
            $validated['phone'] = $this->phoneService->formatE164(
                $validated['phone']
            );
        }

        $contactMessage = ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'unread',
        ]);

        $this->notificationService->notifyNewContact($contactMessage);

        return redirect()
            ->route('contact')
            ->with(
                'success',
                'Your message has been sent. We will get back to you within 24 hours!'
            )
            ->with('_nocache', time());
    }
}