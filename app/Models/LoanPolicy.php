<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanPolicy extends Model
{
    protected $fillable = ['loan_days', 'loan_fee', 'late_fee_per_day'];
}
