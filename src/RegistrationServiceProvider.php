<?php

namespace MrLikviduk\Registration;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Queue;
use MrLikviduk\Registration\Jobs\SendPlannedMail;
use MrLikviduk\Registration\Jobs\SendRegistrationMail;

class RegistrationServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */

    public function register()
    {
        $this->app->singleton('mrlikviduk.registration.console.kernel', function($app) {
            $dispatcher = $app->make(\Illuminate\Contracts\Events\Dispatcher::class);
            return new \MrLikviduk\Registration\Console\Kernel($app, $dispatcher);
        });

        $this->app->make('mrlikviduk.registration.console.kernel');
    }

    public function boot()
    {
        parent::boot();

        $this->loadViewsFrom(__DIR__.'/views', 'registration');

        Event::listen('Illuminate\\Auth\\Events\\Registered', function ($event) {
            $user = $event->user;
            $date = Carbon::now()->addMinutes(15);
            Queue::later($date, new SendRegistrationMail($user, 'user'));
            Queue::later($date, new SendRegistrationMail($user, 'admin'));
            for ($i = 0; $i < 3; $i++) {
                Queue::later(Carbon::now()->addMinutes(30)->addDays($i), new SendPlannedMail($user, $i + 1));
            }
        });
    }
}
