<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'member_id',
        'borrowed_at',
        'due_at',
        'returned_at',
        'is_overdue',
        'fee',
    ];

    protected $dates = [
        'borrowed_at',
        'due_at',
        'returned_at',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function payment()
    {
        return $this->hasOne(\App\Models\Payment::class);
    }

    // Ensure date attributes are Carbon instances even when stored as strings
    public function getBorrowedAtAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    public function getDueAtAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    public function getReturnedAtAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }
}
