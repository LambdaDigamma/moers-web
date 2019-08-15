<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer|null organisation_id
 */
class Group extends Model
{

    use SoftDeletes;

    /**
     * Returns all Users that belong to this Group.
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Returns the belonging organisation or null if none is set.
     *
     * @return BelongsTo|null
     */
    public function organisation()
    {
        if ($this->organisation_id != null) {
            return $this->belongsTo('App\Organisation');
        } else {
            return null;
        }
    }

    /**
     * Returns all Polls registered for this Group.
     *
     * @return HasMany
     */
    public function polls()
    {
        return $this->hasMany('App\Poll')->with('options');
    }

}
