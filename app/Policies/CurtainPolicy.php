<?php

namespace App\Policies;

use App\Models\Curtain;
use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CurtainPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Curtain  $curtain
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function checkUser(User $user, Curtain $curtain)
    {
        $order = Order::findOrFail($curtain->order_id);
        return ($user->id === $order->user_id || $user->isAdmin())
            ? Response::allow()
            : Response::deny('Debes ser un administrador o dueño de esta orden para poder realizar esta acción.');
    }
}
