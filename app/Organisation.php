<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Entry|null $entry
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AdvEvent[] $events
 * @property-read int|null $events_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Organisation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Organisation newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Organisation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Organisation query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Organisation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Organisation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Organisation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Organisation whereEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Organisation whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Organisation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Organisation whereLogoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Organisation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Organisation whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Organisation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Organisation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Organisation withoutTrashed()
 * @mixin \Eloquent
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
