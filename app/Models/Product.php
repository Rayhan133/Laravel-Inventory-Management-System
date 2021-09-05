<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'smg_manager_id',
        'category_id',
        'unit_id',
        'name',
        'sku',
        'sizes',
        'description',
        'status',
    ];

    protected $casts = [
        'sizes' => 'json'
    ];

    public function price()
    {
        return $this->hasMany(Price::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class, 'product_id', 'id');
    }
}
