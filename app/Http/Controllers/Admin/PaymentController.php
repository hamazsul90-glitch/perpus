<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Loan;
use App\Services\QrisGenerator;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('loan.book', 'loan.member')->orderByDesc('created_at')->get();
        return view('admin.payments.index', compact('payments'));
    }

    public function createForLoan(Loan $loan)
    {
        // create a pending payment for loan fee
        $existing = $loan->payment ?? null;
        return view('admin.payments.create', compact('loan', 'existing'));
    }

    public function store(Request $request, Loan $loan)
    {
        $data = $request->validate([
            'method' => 'required|in:cash,qris',
        ]);

        $amount = $loan->fee ?? 0;
        $existing = $loan->payment;

        if ($existing && $existing->status !== 'paid') {
            if ($data['method'] === 'cash') {
                $existing->update([
                    'method' => 'cash',
                    'status' => 'paid',
                    'paid_at' => Carbon::now(),
                ]);
                return redirect()->route('admin.payments.index')->with('success', 'Payment updated to paid cash.');
            }

            if ($data['method'] === 'qris') {
                if (!$existing->qris_payload) {
                    $existing->qris_payload = QrisGenerator::generate(
                        'PerpusMuda',
                        'Jakarta',
                        $amount,
                        'LN' . $loan->id . '-' . now()->format('YmdHis')
                    );
                    $existing->save();
                }
                return redirect()->route('admin.payments.index')->with('success', 'QRIS payment ready.');
            }
        }

        $payment = Payment::create([
            'loan_id' => $loan->id,
            'amount' => $amount,
            'method' => $data['method'],
            'status' => $data['method'] === 'cash' ? 'paid' : 'pending',
            'paid_at' => $data['method'] === 'cash' ? Carbon::now() : null,
        ]);

        if ($data['method'] === 'qris') {
            $payload = QrisGenerator::generate(
                'PerpusMuda',
                'Jakarta',
                $amount,
                'LN' . $loan->id . '-' . now()->format('YmdHis')
            );
            $payment->qris_payload = $payload;
            $payment->save();
        }

        return redirect()->route('admin.payments.index')->with('success', 'Payment recorded.');
    }

    public function markPaid(Payment $payment)
    {
        $payment->status = 'paid';
        $payment->paid_at = Carbon::now();
        $payment->save();

        return redirect()->route('admin.payments.index')->with('success', 'Payment marked as paid.');
    }
}
