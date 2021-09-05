<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderList extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'unit_id',
        'variant',
        'quantity',
        'note',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function price()
    {
        return $this->belongsTo(Price::class, 'product_id');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
