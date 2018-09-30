<?php

namespace GymManager\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

class LedgerRepository extends BaseRepository
{
    /**
     * Definition of searchable fields.
     *
     * @var array
     */
    protected $fieldSearchable = [
        'branch_id' => '=',
        'created_at' => 'like',
    ];

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
