<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorCount extends Model
{
    protected $table = 'visitor_count';
    protected $primaryKey = 'visitor_id';
    public $timestamps = false;
    
    protected $fillable = [
        'member_id',
        'member_name',
        'institution',
        'checkin_date'
    ];
}
