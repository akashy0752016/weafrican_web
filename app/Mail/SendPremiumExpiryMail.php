<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPremiumExpiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userSubscriptionPlan;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userSubscriptionPlan)
    {
        $this->userSubscriptionPlan = $userSubscriptionPlan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.expiryPremiumMail');
    }
}
