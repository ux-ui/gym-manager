<?php

namespace GymManager\Presenters;

use Illuminate\Contracts\Support\Arrayable;
use McCool\LaravelAutoPresenter\BasePresenter;

class LedgerPresenter extends BasePresenter implements Arrayable
{
    /**
     * Returns the presented type attribute.
     *
     * @return string
     */
    public function _type()
    {
        return $this->wrappedObject->type;
    }

    /**
     * Returns the presented amount attribute.
     *
     * @return string
     */
    public function _amount()
    {
        return number_format($this->wrappedObject->amount);
    }

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
            '_type',
            '_amount',
            '_created_at',
        ]);
    }
}
