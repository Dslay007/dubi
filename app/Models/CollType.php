<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CollType extends Model
{
    protected $table = 'mst_coll_type';
    protected $primaryKey = 'coll_type_id';
    public $timestamps = false;
    protected $fillable = ['coll_type_name', 'input_date', 'last_update'];
}
