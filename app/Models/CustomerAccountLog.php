<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAccountLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_id',
        'image',
        'payment',
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'sales_executive_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
