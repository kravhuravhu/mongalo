<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaptismRequest;
use Illuminate\Http\Request;

class BaptismRequestController extends Controller
{
    public function index()
    {
        $requests = BaptismRequest::orderBy('created_at', 'desc')->get();
        return view('admin.baptisms.index', compact('requests'));
    }

    public function update(Request $request, BaptismRequest $baptismRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,completed',
        ]);

        $baptismRequest->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.baptisms')->with('success', 'Baptism request updated successfully!');
    }
}