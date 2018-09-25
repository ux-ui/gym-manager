<?php

namespace GymManager\Models;

use GymManager\Presenters\UserPresenter;
use Illuminate\Notifications\Notifiable;
use McCool\LaravelAutoPresenter\HasPresenter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasPresenter
{
    use Notifiable;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'name',
        'title',
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
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return UserPresenter::class;
    }

    /**
     * The branches that belong to the user.
     */
    public function branches()
    {
        return $this->belongsToMany(Branch::class);
    }

    /**
     * Get branches as plucked array of the specified key.
     *
     * @param  string  $key
     * @return int[]
     */
    public function branchesToPluckedArray(string $key)
    {
        return $this->branches->pluck($key)->toArray();
    }
}
