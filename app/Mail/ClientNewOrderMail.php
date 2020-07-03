<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientNewOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $order, $price, $soloduo, $type, $info;


    public function __construct($order, $price, $soloduo, $type, $info)
    {
        $this->order = $order;
        $this->price = $price;
        $this->soloduo = $soloduo;
        $this->type = $type;
        $this->info = $info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('BMS Boosting Order Confirmation (ID: '+$this->order->order_id+')')->markdown('emails.clientneworder');
    }
}
