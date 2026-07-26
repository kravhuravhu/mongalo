<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaptismRequest;
use Illuminate\Http\Request;

class BaptismRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = BaptismRequest::query();

        // ─── SEARCH ───
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        // ─── FILTER ───
        if ($request->status && in_array($request->status, ['pending', 'contacted', 'completed'])) {
            $query->where('status', $request->status);
        }

        // ─── SORT BY LATEST ───
        $query->orderBy('created_at', 'desc');

        $baptisms = $query->paginate(20);

        // ─── AJAX REQUEST ───
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.baptisms._table', compact('baptisms'))->render(),
                'total' => $baptisms->total(),
            ]);
        }

        return view('admin.baptisms.index', compact('baptisms'));
    }

    public function update(Request $request, BaptismRequest $baptismRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,completed',
        ]);

        $baptismRequest->update([
            'status' => $request->status,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
                'status' => $request->status,
            ]);
        }

        return redirect()->route('admin.baptisms')->with('success', 'Baptism request updated successfully!');
    }
}