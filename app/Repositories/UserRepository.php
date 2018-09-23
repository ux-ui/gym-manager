<?php

namespace GymManager\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    function model()
    {
        return \GymManager\Models\User::class;
    }
}
