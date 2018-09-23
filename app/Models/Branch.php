<?php

namespace GymManager\Models;

use Illuminate\Database\Eloquent\Model;
use GymManager\Presenters\BranchPresenter;
use McCool\LaravelAutoPresenter\HasPresenter;

class Branch extends Model implements HasPresenter
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The properties that cannot be mass assigned.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return BranchPresenter::class;
    }

    /**
     * Get the users for the this branch.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
