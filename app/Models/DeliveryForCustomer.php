<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryForCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'customer_id',
        'sales_executive_id',
        'product_quantity',
        'product_cost',
        'note',
        'delivery_status',
    ];
}