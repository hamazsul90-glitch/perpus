<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(Auth::check() && Auth::user()->isAdmin(), 403);
    }

    public function monthlyLoans(Request $request)
    {
        $this->ensureAdmin();

        $year = $request->input('year', date('Y'));

        $rows = Loan::selectRaw("strftime('%m', borrowed_at) as month, count(*) as total_loans, sum(ifnull(fee,0)) as total_income")
            ->whereRaw("strftime('%Y', borrowed_at) = ?", [$year])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($r) {
                $r->month = intval($r->month);
                return $r;
            });

        return view('admin.monthly_loans', compact('rows', 'year'));
    }

    public function memberDelinquency()
    {
        $this->ensureAdmin();

        $members = Member::withCount(['loans as overdue_count' => function ($q) {
            $q->whereNotNull('returned_at')->whereColumn('returned_at', '>', 'due_at');
        }])->orderByDesc('overdue_count')->get();

        return view('admin.member_delinquency', compact('members'));
    }
}
