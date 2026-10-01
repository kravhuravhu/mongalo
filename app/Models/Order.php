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
        'shipping_fee',
        'hardcopy_price',
        'payment_method',
        'payment_status',
        'fulfillment_status',
        'tracking_number',
        'shipped_at',
        'delivered_at',
        'transaction_id',
        'download_token',
        'download_count',
        'expires_at',
        'delivery_type',
        'delivery_region',
        'delivery_name',
        'delivery_phone',
        'delivery_email',
        'delivery_address_1',
        'delivery_address_2',
        'delivery_suburb',
        'delivery_city',
        'delivery_province',
        'delivery_postal_code',
        'delivery_country',
        'delivery_notes',
    ];

    protected $casts = [
        'amount'         => 'decimal:2',
        'shipping_fee'   => 'decimal:2',
        'hardcopy_price' => 'decimal:2',
        'download_count' => 'integer',
        'expires_at'     => 'datetime',
        'shipped_at'     => 'datetime',
        'delivered_at'   => 'datetime',
    ];

    protected $table = 'orders';

    /* ─── BOOT ─── */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_number   = 'ORD-' . date('Y') . '-' . strtoupper(Str::random(8));
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
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            });
    }

    public function scopeHardcopy($query)
    {
        return $query->where('delivery_type', 'hardcopy');
    }

    public function scopeAwaitingShipment($query)
    {
        return $query->where('fulfillment_status', 'awaiting_shipment');
    }

    /* ─── HELPERS ─── */
    public function isDownloadable()
    {
        return $this->payment_status === 'paid'
            && ($this->expires_at === null || $this->expires_at > now());
    }

    public function incrementDownloadCount()
    {
        $this->increment('download_count');
        $this->book()->increment('download_count');
    }

    public function isHardcopy(): bool
    {
        return $this->delivery_type === 'hardcopy';
    }

    public function isDigital(): bool
    {
        return $this->delivery_type !== 'hardcopy';
    }

    /**
     * Whether this order still needs to be physically fulfilled.
     */
    public function needsShipping(): bool
    {
        return $this->isHardcopy()
            && $this->payment_status === 'paid'
            && in_array($this->fulfillment_status, ['awaiting_shipment', 'awaiting_address'], true);
    }

    /* ─── FORMATTED HELPERS ─── */

    /**
     * Multi-line shipping address — useful in emails, admin panel, CSVs.
     */
    public function getFormattedShippingAddressAttribute(): string
    {
        if (!$this->isHardcopy()) {
            return '—';
        }

        $parts = array_filter([
            $this->delivery_name,
            $this->delivery_address_1,
            $this->delivery_address_2,
            $this->delivery_suburb,
            $this->delivery_city,
            $this->delivery_province,
            $this->delivery_postal_code,
            $this->delivery_country,
        ]);

        return implode("\n", $parts);
    }

    /**
     * Single-line shipping address for tables / CSV cells.
     */
    public function getShippingAddressOneLineAttribute(): string
    {
        return $this->isHardcopy()
            ? str_replace("\n", ', ', $this->formatted_shipping_address)
            : '—';
    }

    public function getShippingRegionLabelAttribute(): string
    {
        if (!$this->delivery_region) {
            return '—';
        }

        $regions = config('shop.shipping', []);

        return $regions[$this->delivery_region]['label'] ?? strtoupper($this->delivery_region);
    }

    public function getHasShippingAddressAttribute(): bool
    {
        return $this->isHardcopy() && !empty($this->delivery_address_1) && !empty($this->delivery_city);
    }
}