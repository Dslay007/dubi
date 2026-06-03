<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanHistory extends Model
{
    protected $table = 'loan_history';
    protected $primaryKey = 'loan_id'; // Note: loan_id is not necessarily unique here if it's a log, but usually it corresponds 1:1 with loan in SLiMS.
    
    public $timestamps = false; // SLiMS tables usually use custom timestamps
    
    protected $guarded = [];

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id', 'loan_id');
    }
}
