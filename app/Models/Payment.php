<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['loan_id', 'amount', 'method', 'status', 'paid_at', 'qris_payload'];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
