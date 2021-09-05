<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'product_id',
        'purchase_team_id',
        'product_count',
        'product_cost',
    ];
}