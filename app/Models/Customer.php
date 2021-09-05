<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'unique_id',
        'sales_executive_id',
        'zone_id',
        'name',
        'phone',
        'address_line_1',
        'address_line_2',
        'store_address',
        'nid_image',
        'account_status',
        'account_type'
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
    public function customerAccountLog()
    {
        return $this->belongsTo(CustomerAccountLog::class, 'order_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function orderLists()
    {
        return $this->hasMany(OrderList::class);
    }
    public function price()
    {
        return $this->hasMany(Price::class, 'product_id');
    }
}
