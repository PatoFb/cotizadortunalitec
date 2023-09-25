<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UsuarioRegistrado extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;

    /**
     * OrdenAProduccion constructor.
     * @param User $user
     */
    public function __construct(array $user)
    {
        $this->user =  $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nuevo socio registrado')->view('mail.registered');
    }
}
