<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_team_id',
        'zone_id',
        'name',
        'email',
        'phone',
        'address_line_1',
        'address_line_2',
        'area',
        'city',
        'image',
        'nid_image',
        'account_balance',
        'account_d`ue',
        'account_type',
        'account_status',
    ];


    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
