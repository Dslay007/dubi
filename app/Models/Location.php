<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'mst_location';
    protected $primaryKey = 'location_id';
    public $incrementing = false; // Based on schema it's varchar(3), but wait, in SLiMS it's usually char(3) or varchar(3) for locations.
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
        'location_id',
        'location_name',
        'input_date',
        'last_update'
    ];
}
