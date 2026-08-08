<?php

namespace App\Services;

use App\Mail\AdminBaptismNotification;
use App\Mail\AdminContactNotification;
use App\Mail\AdminInviteNotification;
use App\Mail\AdminOrderNotification;
use App\Models\BaptismRequest;
use App\Models\ContactMessage;
use App\Models\InviteRequest;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AdminNotificationService
{
    protected string $adminEmail;
    protected string $adminName;

    public function __construct()
    {
        $this->adminEmail = config('app.admin_email');
        $this->adminName = config('app.admin_name', 'The Collective Admin');
    }

    /* ─── ORDER NOTIFICATION ─── */
    public function notifyNewOrder(Order $order): void
    {
        try {
            Mail::to($this->adminEmail)->send(new AdminOrderNotification($order));
            
            Log::info('Admin notified of new order', [
                'order_number' => $order->order_number,
                'admin_email' => $this->adminEmail,
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to send admin order notification', [
                'order_number' => $order->order_number,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /* ─── BAPTISM NOTIFICATION ─── */
    public function notifyNewBaptism(BaptismRequest $baptism): void
    {
        try {
            Mail::to($this->adminEmail)->send(new AdminBaptismNotification($baptism));
            
            Log::info('Admin notified of new baptism request', [
                'baptism_id' => $baptism->id,
                'admin_email' => $this->adminEmail,
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to send admin baptism notification', [
                'baptism_id' => $baptism->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /* ─── CONTACT MESSAGE NOTIFICATION ─── */
    public function notifyNewContact(ContactMessage $message): void
    {
        try {
            Mail::to($this->adminEmail)->send(new AdminContactNotification($message));
            
            Log::info('Admin notified of new contact message', [
                'message_id' => $message->id,
                'admin_email' => $this->adminEmail,
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to send admin contact notification', [
                'message_id' => $message->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /* ─── INVITE REQUEST NOTIFICATION ─── */
    public function notifyNewInvite(InviteRequest $invite): void
    {
        try {
            Mail::to($this->adminEmail)->send(new AdminInviteNotification($invite));
            
            Log::info('Admin notified of new invite request', [
                'invite_id' => $invite->id,
                'admin_email' => $this->adminEmail,
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to send admin invite notification', [
                'invite_id' => $invite->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}