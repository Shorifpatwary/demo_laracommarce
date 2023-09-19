<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\EnumeratesValues;
use Mohsentm\EnumValue;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'name',
        'slug',
    ];

    // Define the relationship with the "Product" model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
