<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        // ─── SEARCH ───
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('subject', 'like', '%' . $search . '%')
                  ->orWhere('message', 'like', '%' . $search . '%');
            });
        }

        // ─── FILTER ───
        if ($request->status && in_array($request->status, ['unread', 'read', 'replied'])) {
            $query->where('status', $request->status);
        }

        // ─── SORT BY LATEST ───
        $query->orderBy('created_at', 'desc');

        $messages = $query->paginate(20);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.messages._table', compact('messages'))->render(),
                'total' => $messages->total(),
            ]);
        }

        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        if ($message->status === 'unread') {
            $message->update(['status' => 'read']);
            
            Log::info('Contact message marked as read', [
                'message_id' => $message->id,
                'from' => $message->email,
                'admin_id' => session('admin_id'),
                'admin_name' => session('admin_name'),
            ]);
        }
        return view('admin.messages.show', compact('message'));
    }

    public function update(Request $request, ContactMessage $message)
    {
        $request->validate([
            'status' => 'required|in:unread,read,replied',
        ]);

        $oldStatus = $message->status;
        $newStatus = $request->status;

        $message->update([
            'status' => $newStatus,
        ]);

        Log::info('Contact message status updated by admin', [
            'message_id' => $message->id,
            'from' => $message->email,
            'subject' => $message->subject,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'ip' => $request->ip(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
                'status' => $newStatus,
            ]);
        }

        return redirect()->route('admin.messages')->with('success', 'Message status updated successfully!');
    }

    /**
     * Mark message as replied (AJAX)
     */
    public function markReplied(ContactMessage $message, Request $request)
    {
        $oldStatus = $message->status;
        $message->update(['status' => 'replied']);

        Log::info('Contact message marked as replied by admin', [
            'message_id' => $message->id,
            'from' => $message->email,
            'subject' => $message->subject,
            'old_status' => $oldStatus,
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'ip' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message marked as replied!',
            'status' => 'replied',
        ]);
    }

    /**
     * Build email reply template with styled HTML
     */
    public function getReplyTemplate(ContactMessage $message)
    {
        $adminName = config('app.admin_name', 'Admin');
        $adminEmail = config('app.admin_email', 'admin@example.com');
        $adminPhone = config('app.app_contact_phone', '+27 71 461 1401');
        $website = config('app.url', 'https://thecollective.co.za');
        $projectName = config('app.name', 'The Collective');

        // ─── BUILD QUOTED MESSAGE WITH STYLING ───
        $date = $message->created_at->format('F d, Y');
        $time = $message->created_at->format('g:i A');
        $quotedMessage = wordwrap($message->message, 70, "\n", true);
        
        // ─── BUILD HTML EMAIL TEMPLATE ───
        $body = "Hello {$message->name},\n\n";
        $body .= "─────────────────────────────\n\n";
        $body .= "On {$date} at {$time}, {$message->name} wrote:\n\n";
        $body .= "> " . str_replace("\n", "\n> ", $quotedMessage) . "\n";
        $body .= "\n─────────────────────────────\n\n";
        $body .= "-- \n";
        $body .= "{$adminName}\n";
        $body .= "{$adminEmail}\n";
        $body .= "{$adminPhone}\n";
        $body .= "{$website}\n";
        $body .= "{$projectName}";

        return response()->json([
            'subject' => 'Re: ' . $message->subject,
            'to' => $message->email,
            'body' => $body,
            'name' => $message->name,
        ]);
    }
}