<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $stock;
    public $payment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($stock, $payment)
    {
        $this->stock = $stock;
        $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
        ->view('emails.purchase')
        ->with([
            'stock' => $this->stock,
            'payment' => $this->payment
        ]);
    }
}
