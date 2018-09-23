<?php

namespace GymManager\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\GymManager\Repositories\UserRepository::class);
        $this->app->singleton(\GymManager\Repositories\BranchRepository::class);
        $this->app->singleton(\GymManager\Repositories\MemberRepository::class);
        $this->app->singleton(\GymManager\Repositories\LedgerRepository::class);
    }
}
