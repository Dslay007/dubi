<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistrantAnswer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function registrant()
    {
        return $this->belongsTo(EventRegistrant::class, 'registrant_id');
    }

    public function field()
    {
        return $this->belongsTo(EventFormField::class, 'field_id');
    }
}
