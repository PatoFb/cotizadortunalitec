<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoGenerado extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;

    /**
     * OrdenAProduccion constructor.
     * @param User $user
     * @param Order $order
     */
    public function __construct(User $user, Order $order)
    {
        $this->user =  $user;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pedido generado')->view('mail.generated');
    }
}
