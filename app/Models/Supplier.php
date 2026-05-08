<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'mst_supplier';
    protected $primaryKey = 'supplier_id';
    public $timestamps = false;
    
    protected $fillable = [
        'supplier_name',
        'address',
        'postal_code',
        'phone',
        'contact',
        'fax',
        'account',
        'e_mail',
        'input_date',
        'last_update'
    ];
}
