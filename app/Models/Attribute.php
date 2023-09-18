<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    // protected $table = 'attributes';

    protected $fillable = [
        'Type',
        'Name',
        'product_id',
    ];

    // Define the relationship with the "Product" model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
