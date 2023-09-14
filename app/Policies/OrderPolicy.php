<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function checkUser(User $user, Order $order) {
        return ($user->id === $order->user_id || $user->isAdmin())
            ? Response::allow()
            : Response::deny('Debes ser un administrador o dueño de esta orden para poder realizar esta acción.');
    }
}
