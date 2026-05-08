<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaType extends Model
{
    protected $table = 'mst_media_type';
    public $timestamps = false;
    
    protected $fillable = [
        'media_type',
        'code',
        'input_date',
        'last_update'
    ];
}
