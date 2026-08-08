<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query()->with('book');

        /* ─── SEARCH ─── */
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                    ->orWhere('buyer_name', 'like', '%' . $search . '%')
                    ->orWhere('buyer_email', 'like', '%' . $search . '%')
                    ->orWhereHas('book', function($bookQuery) use ($search) {
                        $bookQuery->where('title', 'like', '%' . $search . '%');
                    });
            });
        }

        /* ─── FILTER BY STATUS ─── */
        if ($request->status && in_array($request->status, ['pending', 'paid', 'failed', 'refunded'])) {
            $query->where('payment_status', $request->status);
        }

        /* ─── SORT BY LATEST ─── */
        $query->orderBy('created_at', 'desc');

        $orders = $query->paginate(20);

        /* ─── GET COUNTS FOR DISPLAY ─── */
        $pendingCount = Order::where('payment_status', 'pending')->count();
        $paidCount = Order::where('payment_status', 'paid')->count();
        $failedCount = Order::where('payment_status', 'failed')->count();
        $refundedCount = Order::where('payment_status', 'refunded')->count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('amount');

        /* ─── AJAX REQUEST ─── */
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.orders._table', compact('orders'))->render(),
                'total' => $orders->total(),
            ]);
        }

        return view('admin.orders.index', compact(
            'orders',
            'pendingCount',
            'paidCount',
            'failedCount',
            'refundedCount',
            'totalOrders',
            'totalRevenue'
        ));
    }

    public function show(Order $order)
    {
        $order->load('book');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $oldStatus = $order->payment_status;
        $newStatus = $request->payment_status;

        $order->update([
            'payment_status' => $newStatus,
        ]);

        Log::info('Order status updated by admin', [
            'order_number' => $order->order_number,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'admin' => session('admin_name', 'Admin'),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully!',
                'status' => $newStatus,
                'old_status' => $oldStatus,
            ]);
        }

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order status updated successfully!');
    }

    public function destroy(Order $order)
    {
        $orderNumber = $order->order_number;
        $order->delete();

        Log::info('Order deleted by admin', [
            'order_number' => $orderNumber,
            'admin' => session('admin_name', 'Admin'),
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully!');
    }
}