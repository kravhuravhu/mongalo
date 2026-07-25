<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InviteRequest;
use Illuminate\Http\Request;

class InviteRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = InviteRequest::query();

        // ─── SEARCH ───
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('event_name', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        // ─── FILTER ───
        if ($request->status && in_array($request->status, ['pending', 'contacted', 'confirmed'])) {
            $query->where('status', $request->status);
        }

        // ─── SORT BY LATEST ───
        $query->orderBy('created_at', 'desc');

        $invites = $query->paginate(20);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.invites._table', compact('invites'))->render(),
                'total' => $invites->total(),
            ]);
        }

        return view('admin.invites.index', compact('invites'));
    }

    public function update(Request $request, InviteRequest $invite)
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,confirmed',
        ]);

        $invite->update([
            'status' => $request->status,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
                'status' => $request->status,
            ]);
        }

        return redirect()->route('admin.invites')->with('success', 'Invite request updated successfully!');
    }
}