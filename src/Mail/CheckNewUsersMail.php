<?php

namespace MrLikviduk\Registration\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckNewUsersMailMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $users_count;

    protected $periodicity;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($users_count, $periodicity)
    {
        $this->users_count = $users_count;
        $this->periodicity = $periodicity;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('registration::check-new-users-mail', [
            'users_count' => $this->users_count,
            'periodicity' => $this->periodicity
        ])->
        to(Config::get('mail.from.address'), Config::get('mail.from.name'));
    }
}
