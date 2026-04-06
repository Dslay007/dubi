<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberType extends Model
{
    protected $table = 'member_types';
    protected $primaryKey = 'member_type_id';
    protected $guarded = ['member_type_id'];
    
    const CREATED_AT = 'input_date';
    const UPDATED_AT = 'last_update';
}
