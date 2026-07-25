<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

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
        }
        return view('admin.messages.show', compact('message'));
    }

    public function update(Request $request, ContactMessage $message)
    {
        $request->validate([
            'status' => 'required|in:unread,read,replied',
        ]);

        $message->update([
            'status' => $request->status,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
                'status' => $request->status,
            ]);
        }

        return redirect()->route('admin.messages')->with('success', 'Message status updated successfully!');
    }
}