<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaptismRequest;
use App\Models\BaptismRequest as BaptismRequestModel;
use App\Services\AdminNotificationService;
use App\Services\PhoneService;

class BaptismController extends Controller
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
        return view('public.baptism.index');
    }

    public function request(BaptismRequest $request)
    {
        $validated = $request->validated();

        // Format phone number
        $validated['phone'] = $this->phoneService->formatE164($validated['phone']);

        $baptism = BaptismRequestModel::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'location' => $validated['location'],
            'preferred_date' => $validated['preferred_date'] ?? null,
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        // ─── SEND ADMIN NOTIFICATION ───
        $this->notificationService->notifyNewBaptism($baptism);

        // ─── SINGLE FLASH MESSAGE WITH CACHE-BUSTING ───
        return redirect()->route('baptism', ['#baptism-form'])
            ->with('success', 'Your baptism request has been submitted. We will contact you soon!')
            ->with('_nocache', time());
    }
}