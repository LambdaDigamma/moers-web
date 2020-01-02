<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Group
 *
 * @property integer|null organisation_id
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int|null $organisation_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Poll[] $polls
 * @property-read int|null $polls_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Group onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereOrganisationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Group whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Group withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Group withoutTrashed()
 * @mixin \Eloquent
 */
class Group extends Model
{

    protected $fillable = ['name', 'description', 'organisation_id'];

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
     * Returns all Polls registered for this Group with their corresponding PollOptions.
     *
     * @return HasMany
     */
    public function polls()
    {
        return $this->hasMany('App\Poll')->with('options:id,name,poll_id,created_at,updated_at');
    }

}
