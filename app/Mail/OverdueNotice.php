<?php

namespace App\Mail;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OverdueNotice extends Mailable
{
    use Queueable, SerializesModels;

    public Loan $loan;

    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    public function build()
    {
        return $this->subject('Pemberitahuan: Peminjaman Terlambat')
                    ->view('emails.overdue')
                    ->with(['loan' => $this->loan]);
    }
}
