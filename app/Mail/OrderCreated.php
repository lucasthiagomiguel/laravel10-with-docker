<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

   
    public function __construct(Order $order)
    {
        $this->order = $order;
    }


    public function build()
    {
        return $this->subject('Your Order Details')
            ->markdown('emails.order.created')
            ->with([
                'order' => $this->order,
                'client' => $this->order->client,
                'products' => $this->order->products,
        ]);
    }
}
