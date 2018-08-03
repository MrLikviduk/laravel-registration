<?php

namespace MrLikviduk\Registration\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PlannedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    protected $count;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $count)
    {
        $this->user = $user;
        $this->count = $count;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('registration::planned-mail', [
            'count' => $this->count
        ])->
        from(Config::get('mail.from.address'), Config::get('mail.from.name'))->
        to($this->user->email, $this->user->name);
    }
}
