<?php

namespace GymManager\Repositories\Criteria;

use GymManager\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class OfRelatedBranchCriteria implements CriteriaInterface
{
    /**
     * Branches.
     *
     * @var int[]
     */
    protected $branches;

    /**
     * OfRelatedBranchCriteria constructor.
     *
     * @param  array  $branches
     * @return void
     */
    public function __construct(array $branches)
    {
        $this->branches = $branches;
    }

    /**
     * Apply criteria in query repository.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  \Prettus\Repository\Contracts\RepositoryInterface  $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereHas('branch', function ($query) {
            $query->whereIn('id', $this->branches);
        });
    }
}
