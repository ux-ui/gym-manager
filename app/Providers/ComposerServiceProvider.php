<?php

namespace GymManager\Providers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;
use GymManager\Composers\CurrentUserComposer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @param  \Illuminate\Contracts\View\Factory  $factory
     */
    public function boot(Factory $factory)
    {
        $factory->composer('*', CurrentUserComposer::class);
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
