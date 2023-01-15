<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteMail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailIncludes;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailIncludes)
    {
        $this->mailIncludes = $mailIncludes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('You have a Request From Your Friend')->view('friends.invite_mail');
    }
}
