<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
        'price',
        'is_free',
        'is_featured',
        'cover_color',
        'cover_image',
        'book_file',
        'file_type',
        'file_size',
        'download_count',
        'sort_order',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'download_count' => 'integer',
    ];

    protected $table = 'books';

    /* ─── BOOT ─── */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($book) {
            if (empty($book->slug)) {
                $book->slug = Str::slug($book->title);
            }
        });
    }

    /* ─── RELATIONSHIPS ─── */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /* ─── ACCESSORS ─── */
    public function getCoverUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/books/covers/' . $this->cover_image);
        }
        return null;
    }

    public function getBookFileUrlAttribute()
    {
        if ($this->book_file) {
            return asset('storage/books/files/' . $this->book_file);
        }
        return null;
    }

    public function getFormattedPriceAttribute()
    {
        if ($this->is_free) {
            return 'Free';
        }
        return $this->price > 0 ? 'R ' . number_format($this->price, 2) : 'Free';
    }

    public function getRawPriceAttribute()
    {
        return (float) $this->attributes['price'];
    }

    public function getIsPurchasableAttribute()
    {
        return $this->price > 0 && !$this->is_free;
    }

    public function getIsDownloadableAttribute()
    {
        return $this->book_file !== null;
    }
}