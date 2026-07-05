<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InviteRequest;
use Illuminate\Http\Request;

class InviteRequestController extends Controller
{
    public function index()
    {
        $requests = InviteRequest::orderBy('created_at', 'desc')->get();
        return view('admin.invites.index', compact('requests'));
    }

    public function update(Request $request, InviteRequest $invite)
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,confirmed',
        ]);

        $invite->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.invites')->with('success', 'Invite request updated successfully!');
    }
}