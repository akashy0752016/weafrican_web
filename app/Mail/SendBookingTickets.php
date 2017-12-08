<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBookingTickets extends Mailable
{
    use Queueable, SerializesModels;

    public $eventTransaction;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($eventTransaction)
    {
        $this->eventTransaction = $eventTransaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.booktickets');
    }
}
