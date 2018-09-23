<?php

namespace GymManager\Policies;

use GymManager\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can index the model.
     *
     * @param  \GymManager\Models\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \GymManager\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \GymManager\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \GymManager\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \GymManager\Models\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \GymManager\Models\User  $user
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \GymManager\Models\User  $user
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->is_admin;
    }
}
