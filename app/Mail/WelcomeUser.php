<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeUser extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('مرحباً بكم '. env('app_name'))->from(env('MAIL_FROM_ADDRESS', env('mail_from_address')),env('MAIL_FROM_NAME', env('app_name')))
            ->view('emails.user.welcome_new_user', ['user' => $this->user, 'token' => $this->token]);
    }
}
