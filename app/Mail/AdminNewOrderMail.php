<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNewOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public $order, $price, $soloduo, $type, $info, $message;

    public function __construct($order, $price, $soloduo, $type, $info, $message)
    {
      $this->order = $order;
      $this->price = $price;
      $this->soloduo = $soloduo;
      $this->type = $type;
      $this->info = $info;
      $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('BMS Boosting New Order')->markdown('emails.adminneworder');
    }
}
