<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isClient', function (User $user) {
            return $user->role ==='client';
        });
        Gate::define('isAdmin', function (User $user) {
            return $user->role ==='admin';
        });

        Gate::define('isMentor', function (User $user) {
            return $user->role ==='mentor';
        });
    }
}
