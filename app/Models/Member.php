<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'member';
    protected $primaryKey = 'member_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    // SLiMS passwords are typically not using Laravel's 'password' column name
    // But Authenticatable expects getAuthPassword() to return the hashed string.
    // We will override this if the column name is 'mpasswd'
    public function getAuthPassword()
    {
        return $this->mpasswd;
    }

    const CREATED_AT = 'input_date';
    const UPDATED_AT = 'last_update';
    
    public function getDateFormat()
    {
        return 'Y-m-d';
    }

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'mpasswd',
        'personal_id',
    ];

    // Relationships
    public function loans()
    {
        return $this->hasMany(Loan::class, 'member_id', 'member_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'member_id', 'member_id');
    }

    public function memberType()
    {
        return $this->belongsTo(MemberType::class, 'member_type_id', 'member_type_id');
    }
}
