<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerVerifyEmail extends Mailable
// class CustomerVerifyEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // public function __construct()
    public function __construct($user)
    {
        $this->user = $user;
        // $this->email = $user->email;
        // $this->token = $user->email_verified_at;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email Verification')->to('johntoto67@gmail.com')
            ->markdown('mail.verifyEmail')
            ->with('user', $this->user);
    }
}