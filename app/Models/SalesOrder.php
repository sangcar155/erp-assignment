<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
protected $fillable = ['customer_name', 'order_date', 'total'];

public function items()
{
    return $this->hasMany(SalesItem::class);
}

}
