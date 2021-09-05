<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_id',
        'product_id',
        'unit_id',
        'variant',
        'status',
        'required_qty',
        'sypplied_qty',
    ];

    public function smgManager()
    {
        return $this->belongsTo(User::class, 'smg_manager_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
