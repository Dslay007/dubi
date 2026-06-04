<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    
    // Admin password column in SLiMS is 'passwd'
    public function getAuthPassword()
    {
        return $this->passwd;
    }

    const CREATED_AT = 'input_date';
    const UPDATED_AT = 'last_update';

    protected $guarded = ['user_id'];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'passwd',
    ];

    public function getDateFormat()
    {
        return 'Y-m-d';
    }
}
