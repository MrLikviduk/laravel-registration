<?php
namespace MrLikviduk\Registration\Console;

use App\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Mail;
use MrLikviduk\Registration\Mail\CheckNewUsersMailMail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        parent::schedule($schedule);

        $schedule->call(function () {
            Mail::queue(new CheckNewUsersMailMail(rand(1, 50), 60));
        })->hourly();

    }
}