<?php

namespace GymManager\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

class LedgerRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    function model()
    {
        return \GymManager\Models\Ledger::class;
    }
}
