<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
