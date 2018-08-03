<?php

namespace MrLikviduk\Registration\Jobs;


use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use MrLikviduk\Registration\Mail\RegistrationMail;

class SendRegistrationMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    protected $role; // Для того, чтобы узнать, кому отправлять письмо

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user, string $role)
    {
        $this->role = $role;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new RegistrationMail($this->user, $this->role));
    }
}
