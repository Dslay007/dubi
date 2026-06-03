<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $table = 'loan';
    protected $primaryKey = 'loan_id';
    
    const CREATED_AT = 'input_date';
    const UPDATED_AT = 'last_update';

    public function getDateFormat()
    {
        return 'Y-m-d';
    }

    protected $guarded = ['loan_id'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_code', 'item_code');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function loanHistory()
    {
        return $this->hasOne(LoanHistory::class, 'loan_id', 'loan_id');
    }
}
