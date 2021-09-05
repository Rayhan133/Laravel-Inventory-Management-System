<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    use HasFactory;


    protected $fillable = [
        'order_list_id',
        'pricing_barcode',
        'delivery_code',
        'pricing_status',
        'delivery_status',
        'quantity',
        'group_by',
    ];


    public function orderList()
    {
        return $this->belongsTo(OrderList::class);
    }
}
