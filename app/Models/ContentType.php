<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
{
    protected $table = 'mst_content_type';
    public $timestamps = false; // Using SLiMS custom timestamps
    
    protected $fillable = [
        'content_type',
        'code',
        'input_date',
        'last_update'
    ];
}
