<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarrierType extends Model
{
    protected $table = 'mst_carrier_type';
    public $timestamps = false;
    
    protected $fillable = [
        'carrier_type',
        'code',
        'input_date',
        'last_update'
    ];
}
