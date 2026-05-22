<?php

return [
    // Default loan period in days
    'loan_days' => env('LOAN_DAYS', 14),

    // Late fee per day (integer, currency units)
    'late_fee_per_day' => env('LATE_FEE_PER_DAY', 5000),
];
