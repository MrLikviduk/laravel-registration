<?php

namespace MrLikviduk\Registration\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckNewUsersMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $users_count;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($users_count)
    {
        $this->users_count = $users_count;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('registration::check-new-users-mail', $this->users_count)->
        to(Config::get('mail.from.address'), Config::get('mail.from.name'));
    }
}
