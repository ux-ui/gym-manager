<?php

namespace GymManager\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

class MemberRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    function model()
    {
        return \GymManager\Models\Member::class;
    }
}
