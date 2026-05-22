<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \\App\\Console\\Commands\\MarkOverdueLoans::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // run daily and mark overdue; to send emails add --send-mail
        $schedule->command('loans:mark-overdue')->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
