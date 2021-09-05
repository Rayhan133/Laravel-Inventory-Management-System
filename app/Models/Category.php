<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'smg_manager_id',
    ];

    public function smgMenager()
    {
        return $this->belongsTo(User::class, 'smg_manager_id', 'id');
    }
}
