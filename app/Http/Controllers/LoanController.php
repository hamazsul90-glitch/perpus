<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Payment;
use App\Services\QrisGenerator;
use App\Services\QrCodeRenderer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\OverdueNotice;

class LoanController extends Controller
{
    public function index()
    {
        $this->ensureAuthenticated();

        $loans = Loan::with(['book', 'member', 'payment'])
            ->when(!Auth::user()->isAdmin(), fn($query) => $query->where('member_id', Auth::user()->member_id))
            ->orderByDesc('borrowed_at')
            ->get();

        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $this->ensureAuthenticated();

        $books = Book::where('copies_available', '>', 0)->orderBy('title')->get();
        $members = Auth::user()->isAdmin()
            ? Member::orderBy('name')->get()
            : collect([Auth::user()->member]);

        $policy = \App\Models\LoanPolicy::first();

        return view('loans.create', compact('books', 'members', 'policy'));
    }

    public function store(Request $request)
    {
        $this->ensureAuthenticated();

        $rules = [
            'book_id' => 'required|exists:books,id',
            'borrowed_at' => 'required|date_format:Y-m-d',
            'payment_method' => 'required|in:cash,qris',
        ];

        if (Auth::user()->isAdmin()) {
            $rules['member_id'] = 'required|exists:members,id';
        }

        $data = $request->validate($rules);

        if (!Auth::user()->isAdmin()) {
            $data['member_id'] = Auth::user()->member_id;
        }

        $book = Book::findOrFail($data['book_id']);
        if ($book->copies_available < 1) {
            return back()->withErrors(['book_id' => 'Buku tidak tersedia saat ini.'])->withInput();
        }

        $book->decrement('copies_available');
        $book->refresh();

        $borrowedAt = Carbon::createFromFormat('Y-m-d', $data['borrowed_at'])->startOfDay();

        $policy = \App\Models\LoanPolicy::first();
        $loanDays = $policy ? $policy->loan_days : config('loans.loan_days', 14);
        $loanFee = $policy ? $policy->loan_fee : 0;

        $dueAt = $borrowedAt->copy()->addDays($loanDays);

        $loan = Loan::create([
            'book_id' => $book->id,
            'member_id' => $data['member_id'],
            'borrowed_at' => $borrowedAt,
            'due_at' => $dueAt,
            'is_overdue' => false,
            'fee' => $loanFee,
        ]);

        $paymentData = [
            'loan_id' => $loan->id,
            'amount' => $loanFee,
            'method' => $data['payment_method'],
            'status' => 'pending',
        ];

        if ($data['payment_method'] === 'qris') {
            $paymentData['qris_payload'] = \App\Services\QrisGenerator::generate(
                'PerpusMuda',
                'Jakarta',
                $loanFee,
                'LN' . $loan->id . '-' . now()->format('YmdHis')
            );
        }

        $loan->payment()->create($paymentData);

        if ($data['payment_method'] === 'qris') {
            return redirect()->route('loans.show', $loan)->with('success', 'Peminjaman berhasil dicatat. Silakan lakukan pembayaran QRIS.');
        }

        return redirect()->route('loans.index')->with('success', 'Peminjaman dicatat. Silakan bayar cash ke admin/kasir.');
    }

    public function show(Loan $loan)
    {
        $this->ensureAuthenticated();

        if (!Auth::user()->isAdmin() && Auth::user()->member_id !== $loan->member_id) {
            abort(403);
        }

        $loan->load(['book', 'member', 'payment']);

        if ($loan->payment && $loan->payment->method === 'qris' && empty($loan->payment->qris_payload)) {
            $dummyReference = 'DUMMY-' . strtoupper(bin2hex(random_bytes(8)));
            $loan->payment->qris_payload = QrisGenerator::generate(
                'PerpusMuda',
                'Jakarta',
                max($loan->payment->amount, 1),
                'LN' . $loan->id . '-' . now()->format('YmdHis') . '-' . $dummyReference
            );
            $loan->payment->save();
            $loan->refresh();
            $loan->load('payment');
        }

        $qrDataUri = '';
        if ($loan->payment && $loan->payment->method === 'qris' && $loan->payment->qris_payload) {
            $qrDataUri = QrCodeRenderer::generateDataUri($loan->payment->qris_payload);
        }

        return view('loans.show', compact('loan', 'qrDataUri'));
    }

    public function markReturned(Loan $loan)
    {
        $this->ensureAuthenticated();

        if (!Auth::user()->isAdmin() && Auth::user()->member_id !== $loan->member_id) {
            abort(403);
        }

        if (!$loan->returned_at) {
            $returnedAt = Carbon::now();
            $loan->returned_at = $returnedAt;

            // compute fee if returned late
            if ($loan->due_at && $returnedAt->greaterThan($loan->due_at)) {
                $daysLate = $returnedAt->diffInDays($loan->due_at);
                $policy = \App\Models\LoanPolicy::first();
                $lateFeePerDay = $policy ? $policy->late_fee_per_day : config('loans.late_fee_per_day', 5000);
                $loan->fee = ($loan->fee ?? 0) + ($daysLate * $lateFeePerDay);
            }

            $loan->is_overdue = false;
            $loan->save();

            $book = $loan->book;
            if ($book->copies_available < $book->copies_total) {
                $book->increment('copies_available');
            }
        }

        return redirect()->route('loans.index')->with('success', 'Buku berhasil ditandai kembali.');
    }

    private function ensureAuthenticated(): void
    {
        abort_unless(Auth::check(), 403);
    }
}
