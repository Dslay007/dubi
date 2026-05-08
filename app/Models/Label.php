<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Label extends Model
{
    protected $table = 'mst_label';
    protected $primaryKey = 'label_id';
    public $timestamps = false;
    protected $fillable = ['label_name', 'label_desc', 'label_image', 'input_date', 'last_update'];
}
