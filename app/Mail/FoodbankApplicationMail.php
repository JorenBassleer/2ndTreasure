<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FoodbankApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $foodbankInformation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->foodbankInformation = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.foodbank_application')
                    ->subject('2ndTreasure - Foodbank application')
                    ->with('foodbankInformation' , $this->foodbankInformation);
    }
}
