<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'customer_type',
        'sales_executive_id',
        'order_no',
        'status'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderList()
    {
        return $this->hasMany(OrderList::class);
    }

    public function sales_executive()
    {
        return $this->belongsTo(User::class, 'sales_executive_id', 'id');
    }

    public function customerAccountLog()
    {
        return $this->belongsTo(CustomerAccountLog::class, 'id');
    }
}
