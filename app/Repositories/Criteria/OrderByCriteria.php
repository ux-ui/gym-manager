<?php

namespace GymManager\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class OrderByCriteria implements CriteriaInterface
{
    /**
     * The column to sort by.
     *
     * @var string
     */
    protected $column;

    /**
     * The method to order by.
     *
     * @var string
     */
    protected $orderBy;

    /**
     * OrderByCriteria constructor.
     *
     * @param  string  $column
     * @param  string  $orderBy
     * @return void
     */
    public function __construct($column = 'updated_at', $orderBy = 'desc')
    {
        $this->column = $column;
        $this->orderBy = $orderBy;
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
        return $model->orderBy($this->column, $this->orderBy);
    }
}
