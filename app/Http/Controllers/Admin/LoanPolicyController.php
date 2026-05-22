<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanPolicy;

class LoanPolicyController extends Controller
{
    public function edit()
    {
        $policy = LoanPolicy::first();
        return view('admin.loan_policy.edit', compact('policy'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'loan_days' => 'required|integer|min:1',
            'loan_fee' => 'required|integer|min:0',
            'late_fee_per_day' => 'required|integer|min:0',
        ]);

        $policy = LoanPolicy::first();
        if (!$policy) {
            $policy = LoanPolicy::create($data);
        } else {
            $policy->update($data);
        }

        return redirect()->route('admin.loan_policy.edit')->with('success', 'Kebijakan pinjaman diperbarui.');
    }
}
