<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
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

    public function checkUser() {
        return (auth()->user()->isAdmin())
            ? Response::allow()
            : Response::deny('Debes ser un administrador para poder realizar esta acción.');
    }
}
