<?php

namespace GymManager\Models;

use Illuminate\Database\Eloquent\Model;
use GymManager\Presenters\LedgerPresenter;
use McCool\LaravelAutoPresenter\HasPresenter;

class Ledger extends Model implements HasPresenter
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'branch_id',
        'user_id',
        'type',
        'purpose',
        'amount',
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
        return LedgerPresenter::class;
    }

    /**
     * Get the user that owns the ledger.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the branch that owns the ledger.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
