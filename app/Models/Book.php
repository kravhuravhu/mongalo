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
        'sort_order',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
    ];

    protected $table = 'books';

    public static function boot()
    {
        parent::boot();
        static::creating(function ($book) {
            if (empty($book->slug)) {
                $book->slug = Str::slug($book->title);
            }
        });
    }

    public function getFormattedPriceAttribute()
    {
        return $this->price > 0 ? 'R ' . number_format($this->price, 2) : 'Free';
    }

    public function getRawPriceAttribute()
    {
        return (float) $this->attributes['price'];
    }

    public function getPriceAttribute($value)
    {
        return $value > 0 ? 'R ' . number_format($value, 2) : 'Free';
    }
}