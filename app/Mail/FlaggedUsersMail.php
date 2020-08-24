<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FlaggedUsersMail extends Mailable
{
    use Queueable, SerializesModels;

    public $flaggedUsers;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($flaggedUsers)
    {
        $this->flaggedUsers = $flaggedUsers;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Mail for admin
        return $this->markdown('emails.flagged_users_mail')
                    ->subject('2ndTreasure - Bad users report')
                    ->with('flaggedUsers', $this->flaggedUsers);
    }
}
