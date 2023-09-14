<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\Palilleria;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PalilleriaPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     */
    public function checkUser(User $user, Palilleria $palilleria)
    {
        $order = Order::findOrFail($palilleria->order_id);
        return ($user->id === $order->user_id || $user->isAdmin())
            ? Response::allow()
            : Response::deny('Debes ser un administrador o dueño de esta orden para poder realizar esta acción.');
    }
}
