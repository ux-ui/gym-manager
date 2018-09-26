<?php

namespace GymManager\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \GymManager\Models\User::class => \GymManager\Policies\AdminPolicy::class,
        \GymManager\Models\Branch::class => \GymManager\Policies\AdminPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('only-admin', function ($user) {
            return $user->is_admin === true;
        });
    }
}
