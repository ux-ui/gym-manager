<?php

namespace GymManager\Presenters;

use Illuminate\Contracts\Support\Arrayable;
use McCool\LaravelAutoPresenter\BasePresenter;

class BranchPresenter extends BasePresenter implements Arrayable
{
    /**
     * Returns the presented created_at attribute.
     *
     * @return string
     */
    public function _created_at()
    {
        return $this->wrappedObject->created_at->format('Y-m-d');
    }

    /**
     * Convert the presenter instance to an array.
     *
     * @return string[]
     */
    public function toArray()
    {
        return array_merge($this->wrappedObject->toArray(), [
            '_created_at',
        ]);
    }
}
