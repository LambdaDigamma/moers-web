<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Organisation
 *
 * @property integer|null group_id
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int|null $entry_id
 * @property int|null $group_id
 * @property string|null $tags
 * @property string|null $logo_url
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Entry|null $entry
 * @property-read Collection|AdvEvent[] $events
 * @property-read int|null $events_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static bool|null forceDelete()
 * @method static Builder|Organisation newModelQuery()
 * @method static Builder|Organisation newQuery()
 * @method static \Illuminate\Database\Query\Builder|Organisation onlyTrashed()
 * @method static Builder|Organisation query()
 * @method static bool|null restore()
 * @method static Builder|Organisation whereCreatedAt($value)
 * @method static Builder|Organisation whereDeletedAt($value)
 * @method static Builder|Organisation whereDescription($value)
 * @method static Builder|Organisation whereEntryId($value)
 * @method static Builder|Organisation whereGroupId($value)
 * @method static Builder|Organisation whereId($value)
 * @method static Builder|Organisation whereLogoUrl($value)
 * @method static Builder|Organisation whereName($value)
 * @method static Builder|Organisation whereTags($value)
 * @method static Builder|Organisation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Organisation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Organisation withoutTrashed()
 * @mixin Eloquent
 */
class Organisation extends Model
{

    use SoftDeletes;

    protected $table = 'organisations';

    protected $fillable = ['name', 'description'];

    public function users() {
        return $this->belongsToMany('App\User')->withPivot('organisation_id', 'user_id', 'role');
    }

    public function entry() {
        return $this->belongsTo('App\Entry');
    }

    public function events() {
        return $this->hasMany('App\AdvEvent')->whereDate('start_date', '>', Carbon::yesterday()->toDateString());
    }

    /**
     * Returns the Main Group or null if none is set.
     *
     * @return HasOne|null
     */
    public function mainGroup()
    {
        if ($this->group_id != null) {
            return $this->hasOne('App\Group');
        } else {
            return null;
        }
    }

}
