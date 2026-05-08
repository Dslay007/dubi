<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistrant extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'registered_at' => 'datetime',
    ];

    public function form()
    {
        return $this->belongsTo(EventForm::class, 'event_form_id');
    }

    public function answers()
    {
        return $this->hasMany(EventRegistrantAnswer::class, 'registrant_id');
    }
}
