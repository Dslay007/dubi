<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biblio extends Model
{
    use HasFactory;

    protected $table = 'biblio';
    protected $primaryKey = 'biblio_id';
    
    // Disable timestamps if SLiMS uses different column names (input_date, last_update)
    // SLiMS uses 'input_date' and 'last_update' but Laravel expects 'created_at' and 'updated_at'
    const CREATED_AT = 'input_date';
    const UPDATED_AT = 'last_update';

    public function getDateFormat()
    {
        return 'Y-m-d';
    }

    protected $guarded = ['biblio_id'];
    protected $appends = ['author'];

    public function getAuthorAttribute()
    {
        return $this->authors->first();
    }

    public function gmd()
    {
        return $this->belongsTo(Gmd::class, 'gmd_id', 'gmd_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id', 'publisher_id');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'biblio_author', 'biblio_id', 'author_id')->withPivot('level');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'biblio_id', 'biblio_id');
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'biblio_topic', 'biblio_id', 'topic_id');
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'publish_place_id', 'place_id');
    }
}
