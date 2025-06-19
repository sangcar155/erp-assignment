<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesItem extends Model
{
    use HasFactory;

protected $fillable = [
    'sales_order_id',
    'product_id',
    'quantity',
    'price',
    'subtotal', // ✅ this is essential
];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
