<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $table = 'mst_servers';
    protected $primaryKey = 'server_id';
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'uri',
        'server_type',
        'input_date',
        'last_update'
    ];
}
