<?php
namespace MrLikviduk\Registration\Console;

use App\Console\Kernel as ConsoleKernel;
use App\User;
use Carbon\Carbon;
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

        $periodicity = 90; // Периодичность проверки (в минутах)

        $schedule->call(function () {
            $periodicity = 90; // Периодичность проверки (в минутах)
            $users_count = User::where('created_at', '>=', Carbon::now()->subMinutes($periodicity))->count();
            Mail::queue(new CheckNewUsersMailMail($users_count, $periodicity));
        })->cron('*/'.$periodicity.' * * * *');

    }
}