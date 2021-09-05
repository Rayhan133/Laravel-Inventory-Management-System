<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_history extends Model
{
    // protected $guarded = [];

    protected $fillable = [
        'customer_account_log_id',
        'customer_id',
        'order_id',
        'payment_history',
        'image',
    ];
    use HasFactory;
}
