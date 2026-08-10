<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\EventRegistration;
use App\Models\BaptismRequest;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class ExportController extends Controller
{
    /**
     * Export Orders to CSV
     */
    public function orders(Request $request)
    {
        $query = Order::with('book');

        // ─── APPLY FILTERS ───
        if ($request->status) {
            $query->where('payment_status', $request->status);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        $headers = [
            'Order Number',
            'Book',
            'Buyer Name',
            'Buyer Email',
            'Buyer Phone',
            'Amount',
            'Payment Status',
            'Payment Method',
            'Transaction ID',
            'Download Count',
            'Created At',
        ];

        $rows = $orders->map(function ($order) {
            return [
                $order->order_number,
                $order->book->title ?? 'N/A',
                $order->buyer_name,
                $order->buyer_email,
                $order->buyer_phone ?? 'N/A',
                $order->amount,
                ucfirst($order->payment_status),
                $order->payment_method ?? 'N/A',
                $order->transaction_id ?? 'N/A',
                $order->download_count,
                $order->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return $this->downloadCsv('orders_' . date('Y-m-d') . '.csv', $headers, $rows);
    }

    /**
     * Export Event Registrations to CSV
     */
    public function registrations(Request $request)
    {
        $query = EventRegistration::with('event');

        if ($request->event_id) {
            $query->where('event_id', $request->event_id);
        }

        if ($request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $registrations = $query->orderBy('created_at', 'desc')->get();

        $headers = [
            'Registration ID',
            'Event',
            'Name',
            'Email',
            'Phone',
            'Payment Status',
            'Registered At',
        ];

        $rows = $registrations->map(function ($reg) {
            return [
                $reg->registration_id,
                $reg->event->title ?? 'N/A',
                $reg->name,
                $reg->email,
                $reg->phone,
                ucfirst($reg->payment_status ?? 'pending'),
                $reg->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return $this->downloadCsv('registrations_' . date('Y-m-d') . '.csv', $headers, $rows);
    }

    /**
     * Export Baptism Requests to CSV
     */
    public function baptisms(Request $request)
    {
        $query = BaptismRequest::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $baptisms = $query->orderBy('created_at', 'desc')->get();

        $headers = [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Location',
            'Preferred Date',
            'Message',
            'Status',
            'Submitted At',
        ];

        $rows = $baptisms->map(function ($baptism) {
            return [
                $baptism->id,
                $baptism->name,
                $baptism->email,
                $baptism->phone,
                $baptism->location,
                $baptism->preferred_date ? $baptism->preferred_date->format('Y-m-d') : 'N/A',
                $baptism->message ?? 'N/A',
                ucfirst($baptism->status),
                $baptism->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return $this->downloadCsv('baptisms_' . date('Y-m-d') . '.csv', $headers, $rows);
    }

    /**
     * Export Contact Messages to CSV
     */
    public function messages(Request $request)
    {
        $query = ContactMessage::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $messages = $query->orderBy('created_at', 'desc')->get();

        $headers = [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Subject',
            'Message',
            'Status',
            'Submitted At',
        ];

        $rows = $messages->map(function ($message) {
            return [
                $message->id,
                $message->name,
                $message->email,
                $message->phone ?? 'N/A',
                $message->subject,
                $message->message,
                ucfirst($message->status),
                $message->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return $this->downloadCsv('messages_' . date('Y-m-d') . '.csv', $headers, $rows);
    }

    /**
     * Download CSV file
     */
    protected function downloadCsv(string $filename, array $headers, $rows)
    {
        $callback = function () use ($headers, $rows) {
            $handle = fopen('php://output', 'w');

            // ─── ADD UTF-8 BOM FOR EXCEL COMPATIBILITY ───
            fwrite($handle, "\xEF\xBB\xBF");

            // ─── WRITE HEADERS ───
            fputcsv($handle, $headers);

            // ─── WRITE ROWS ───
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'public',
            'Expires' => '0',
        ]);
    }
}