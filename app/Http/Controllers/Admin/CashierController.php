<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['book', 'member', 'payment'])
            ->where('fee', '>', 0)
            ->where(function ($query) {
                $query->whereDoesntHave('payment')
                    ->orWhereHas('payment', function ($query) {
                        $query->where('status', '!=', 'paid');
                    });
            })
            ->orderBy('due_at')
            ->get();

        return view('admin.cashier.index', compact('loans'));
    }
}
