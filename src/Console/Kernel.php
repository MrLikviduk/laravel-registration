<?php
namespace MrLikviduk\Registration\Console;

use App\Console\Kernel as ConsoleKernel;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Mail;
use MrLikviduk\Registration\Mail\CheckNewUsersMail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected $cron = '0 * * * *';

    protected function schedule(Schedule $schedule)
    {
        parent::schedule($schedule);

        $schedule->call(function () {
            $users_count = [
                'hour' => User::where('created_at', '>=', Carbon::now()->subHour())->count(),
                'day' => User::where('created_at', '>=', Carbon::now()->subDay())->count(),
                'week' => User::where('created_at', '>=', Carbon::now()->subWeek())->count(),
                'month' => User::where('created_at', '>=', Carbon::now()->subDays(30))->count()
            ];
            Mail::queue(new CheckNewUsersMail($users_count));
        })->cron($this->cron);

    }
}