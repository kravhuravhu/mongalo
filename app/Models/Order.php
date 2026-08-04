<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'book_id',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'amount',
        'payment_method',
        'payment_status',
        'transaction_id',
        'download_token',
        'download_count',
        'expires_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'download_count' => 'integer',
        'expires_at' => 'datetime',
    ];

    protected $table = 'orders';

    /* ─── BOOT ─── */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . date('Y') . '-' . strtoupper(Str::random(8));
            $order->download_token = Str::random(64);
        });
    }

    /* ─── RELATIONSHIPS ─── */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /* ─── SCOPES ─── */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeValid($query)
    {
        return $query->where('payment_status', 'paid')
            ->where(function($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    /* ─── HELPERS ─── */
    public function isDownloadable()
    {
        return $this->payment_status === 'paid' && 
            ($this->expires_at === null || $this->expires_at > now());
    }

    public function incrementDownloadCount()
    {
        $this->increment('download_count');
        $this->book()->increment('download_count');
    }
}