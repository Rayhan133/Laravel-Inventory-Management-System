<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function smgManagers()
    {
        return $this->hasMany(User::class);
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }
}
