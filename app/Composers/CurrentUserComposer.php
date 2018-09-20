<?php

namespace GymManager\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use McCool\LaravelAutoPresenter\Facades\AutoPresenter;

class CurrentUserComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\Contracts\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('currentUser', AutoPresenter::decorate(Auth::user()));
    }
}
