<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\Toldo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ToldoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     */
    public function checkUser(User $user, Toldo $toldo)
    {
        $order = Order::findOrFail($toldo->order_id);
        return ($user->id === $order->user_id || $user->isAdmin())
            ? Response::allow()
            : Response::deny('Debes ser un administrador o dueño de esta orden para poder realizar esta acción.');
    }
}
