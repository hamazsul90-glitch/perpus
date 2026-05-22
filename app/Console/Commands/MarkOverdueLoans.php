<?php

namespace App\Console\Commands;

use App\Mail\OverdueNotice;
use App\Models\Loan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class MarkOverdueLoans extends Command
{
    protected $signature = 'loans:mark-overdue {--send-mail}';
    protected $description = 'Mark loans past due date as overdue and optionally send emails.';

    public function handle()
    {
        $now = Carbon::now();
        $loans = Loan::whereNull('returned_at')
            ->where('is_overdue', false)
            ->whereNotNull('due_at')
            ->where('due_at', '<', $now)
            ->with('member.user', 'book')
            ->get();

        $this->info('Found ' . $loans->count() . ' overdue loans to mark.');

        foreach ($loans as $loan) {
            $loan->is_overdue = true;
            $loan->save();

            if ($this->option('send-mail') && $loan->member->email) {
                try {
                    Mail::to($loan->member->email)->send(new OverdueNotice($loan));
                    $this->info('Sent email to ' . $loan->member->email);
                } catch (\Exception $e) {
                    $this->error('Failed sending to ' . $loan->member->email . ': ' . $e->getMessage());
                }
            }
        }

        return 0;
    }
}
