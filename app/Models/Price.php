<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_variant',
        'product_sku',
        'purchase_price',
        'new_price',
        'normal_price',
        'loyal_price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
