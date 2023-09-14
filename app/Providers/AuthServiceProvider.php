<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Order' => 'App\Policies\OrderPolicy',
        'App\Models\Curtain' => 'App\Policies\CurtainPolicy',
        'App\Models\Palilleria' => 'App\Policies\PalilleriaPolicy',
        'App\Models\Toldo' => 'App\Policies\ToldoPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
