<?php

namespace MrLikviduk\Registration\Jobs;


use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use MrLikviduk\Registration\Mail\PlannedMail;

class SendPlannedMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    protected $count;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user, $count)
    {
        $this->user = $user;
        $this->count = $count;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new PlannedMail($this->user, $this->count));
    }
}
