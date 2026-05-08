<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventFormField extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_required' => 'boolean',
        'options' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(EventForm::class, 'event_form_id');
    }

    public function answers()
    {
        return $this->hasMany(EventRegistrantAnswer::class, 'field_id');
    }
}
