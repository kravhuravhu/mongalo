<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\InviteRequest;
use App\Models\InviteRequest as InviteRequestModel;
use App\Services\AdminNotificationService;
use App\Services\PhoneService;

class InviteController extends Controller
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
        return view('public.invite.index');
    }

    public function send(InviteRequest $request)
    {
        $validated = $request->validated();

        // Format phone number
        $validated['phone'] = $this->phoneService->formatE164($validated['phone']);

        $invite = InviteRequestModel::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'event_name' => $validated['event_name'],
            'event_date' => $validated['event_date'],
            'location' => $validated['location'],
            'expected_attendance' => $validated['expected_attendance'] ?? null,
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        // ─── SEND ADMIN NOTIFICATION ───
        $this->notificationService->notifyNewInvite($invite);

        // ─── SINGLE FLASH WITH CACHE-BUSTING ───
        return redirect()->route('invite', ['#invite-form'])
            ->with('success', 'Your invitation request has been sent. Arthur will respond within 48 hours!')
            ->with('_nocache', time());
    }
}