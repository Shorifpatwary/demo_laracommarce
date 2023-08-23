<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'unit',
        'tags',
        'video',
        'purchase_price',
        'selling_price',
        'discount_price',
        'stock_quantity',
        'warehouse',
        'description',
        'thumbnail',
        'images',
        'featured',
        'today_deal',
        'status',
        'flash_deal_id',
        'cash_on_delivery',
        'category_id',
        'brand_id',
        'user_id',
    ];
}
