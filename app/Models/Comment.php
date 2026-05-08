<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';
    protected $primaryKey = 'comment_id';
    public $timestamps = false;
    
    protected $fillable = [
        'biblio_id',
        'member_id',
        'comment',
        'input_date',
        'last_update'
    ];
}
