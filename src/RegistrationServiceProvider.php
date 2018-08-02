<?php

namespace MrLikviduk\Registration;

use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Queue;
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
    public function boot()
    {
        parent::boot();

        Event::listen('Illuminate\\Auth\\Events\\Registered', function ($event) {
            $user = $event->user;
            $date = Carbon::now()->addMinutes(15);
            Queue::later($date, new SendRegistrationMail($user));
        });
    }
}
