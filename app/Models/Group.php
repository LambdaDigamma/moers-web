<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Group
 *
 * @property integer|null organisation_id
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Poll[] $polls
 * @property-read int|null $polls_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static bool|null forceDelete()
 * @method static Builder|Group newModelQuery()
 * @method static Builder|Group newQuery()
 * @method static \Illuminate\Database\Query\Builder|Group onlyTrashed()
 * @method static Builder|Group query()
 * @method static bool|null restore()
 * @method static Builder|Group whereCreatedAt($value)
 * @method static Builder|Group whereDeletedAt($value)
 * @method static Builder|Group whereDescription($value)
 * @method static Builder|Group whereId($value)
 * @method static Builder|Group whereName($value)
 * @method static Builder|Group whereOrganisationId($value)
 * @method static Builder|Group whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Group withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Group withoutTrashed()
 * @mixin Eloquent
 * @property-read Organisation|null $organisation
 * @property int|null $organisation_id
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
        return $this->belongsToMany(User::class);
    }

    /**
     * Returns the belonging organisation or null if none is set.
     *
     * @return BelongsTo|null
     */
    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    /**
     * Returns all Polls registered for this Group with their corresponding PollOptions.
     *
     * @return HasMany
     */
    public function polls()
    {
        return $this->hasMany(Poll::class)->with('options:id,name,poll_id,created_at,updated_at');
    }

}
