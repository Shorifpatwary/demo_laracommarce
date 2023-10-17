<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'unit',
        'tags',
        'video',
        'purchase_price',
        'selling_price',
        'discount_price',
        'stock_quantity',
        'description',
        'thumbnail',
        'images',
        'featured',
        'today_deal',
        'trendy',
        'product_slider',
        'status',
        'category_id',
        'brand_id',
        'warehouse_id',
        'pickup_point_id',
        'user_id',
        'color',
        'size'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        // return $this->review()->avg('rating');
        return (float) $this->review()->avg('rating');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function sizes()
    {
        return $this->hasMany(Attribute::class)
            ->where('type', 'size');
    }

    public function colors()
    {
        return $this->hasMany(Attribute::class)
            ->where('type', 'color');
    }

    public function tags()
    {
        return $this->hasMany(Attribute::class)
            ->where('type', 'tag');
    }
}