<?php

namespace MrLikviduk\Registration\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Config;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    protected $role;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->role == 'user') {
            $email = $this->user->email;
            $name = $this->user->name;
            $header = 'Welcome, '.$name;
            $body = 'You have successfully finished the registration!';
        }
        else {
            $email = Config::get('mail.from.address');
            $name = Config::get('mail.from.name');
            $header = 'A new user has registered.';
            $body = 'User\'s name: '.$this->user->name;
        }
        return $this->view('registration::registration-mail', [
            'header' => $header,
            'body' => $body
        ])->
        from(Config::get('mail.from.address'), Config::get('mail.from.name'))->
        to($email, $name);
    }
}
