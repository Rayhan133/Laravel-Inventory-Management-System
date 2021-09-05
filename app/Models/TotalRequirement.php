<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'unit_id',
        'variant',
        'required_qty',
        'supplied_qty',
        'image',
        'note',
        'status',
        'total_price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
