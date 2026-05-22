<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoanPolicy;

class LoanPolicySeeder extends Seeder
{
    public function run()
    {
        LoanPolicy::truncate();

        LoanPolicy::create([
            'loan_days' => 30,
            'loan_fee' => 15000,
            'late_fee_per_day' => 1000,
        ]);
    }
}
