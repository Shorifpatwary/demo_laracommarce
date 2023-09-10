<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];
}
