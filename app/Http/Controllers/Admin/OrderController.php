<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        if ($request->delivery === 'hardcopy') {
            $query->where('delivery_type', 'hardcopy');
        }
        if ($request->fulfillment) {
            $query->where('fulfillment_status', $request->fulfillment);
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
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'ip' => $request->ip(),
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

    public function destroy(Order $order, Request $request)
    {
        $orderNumber = $order->order_number;
        $order->delete();

        Log::info('Order deleted by admin', [
            'order_number' => $orderNumber,
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully!');
    }

    /* ─── MARK AS SHIPPED ─── */
    public function markShipped(Request $request, Order $order)
    {
        $request->validate([
            'tracking_number' => 'nullable|string|max:120',
        ]);

        if (!$order->isHardcopy()) {
            return back()->with('error', 'This order is not a hard copy order.');
        }

        if ($order->payment_status !== 'paid') {
            return back()->with('error', 'Cannot ship an unpaid order.');
        }

        $order->update([
            'fulfillment_status' => 'shipped',
            'tracking_number'    => $request->tracking_number,
            'shipped_at'         => now(),
        ]);

        // ─── EMAIL THE BUYER (non-blocking) ───
        try {
            Mail::to($order->buyer_email)->send(new OrderShipped($order));
        } catch (\Throwable $e) {
            \Log::error('Failed to send OrderShipped email', [
                'order_number' => $order->order_number,
                'error'        => $e->getMessage(),
            ]);
        }

        Log::info('Order marked as shipped', [
            'order_number'    => $order->order_number,
            'tracking_number' => $request->tracking_number,
            'admin_id'        => session('admin_id'),
            'admin_name'      => session('admin_name'),
            'ip'              => $request->ip(),
        ]);

        // email the buyer here:
        Mail::to($order->buyer_email)->send(new OrderShipped($order));

        return back()->with('success', 'Order marked as shipped.');
    }

    /* ─── MARK AS DELIVERED ─── */
    public function markDelivered(Request $request, Order $order)
    {
        if ($order->fulfillment_status !== 'shipped') {
            return back()->with('error', 'Order has not been marked as shipped yet.');
        }

        $order->update([
            'fulfillment_status' => 'delivered',
            'delivered_at'       => now(),
        ]);

        Log::info('Order marked as delivered', [
            'order_number' => $order->order_number,
            'admin_id'     => session('admin_id'),
            'admin_name'   => session('admin_name'),
            'ip'           => $request->ip(),
        ]);

        return back()->with('success', 'Order marked as delivered.');
    }
}