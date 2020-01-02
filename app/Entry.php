<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

/**
 * App\Entry
 *
 * @property int $id
 * @property float $lat
 * @property float $lng
 * @property string $name
 * @property string $tags
 * @property string $street
 * @property string $house_number
 * @property string $postcode
 * @property string $place
 * @property string|null $url
 * @property string|null $phone
 * @property string|null $monday
 * @property string|null $tuesday
 * @property string|null $wednesday
 * @property string|null $thursday
 * @property string|null $friday
 * @property string|null $saturday
 * @property string|null $sunday
 * @property string|null $other
 * @property int|null $user_id
 * @property int $is_validated
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Event[] $events
 * @property-read int|null $events_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Organisation[] $organisations
 * @property-read int|null $organisations_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Entry onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereFriday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereHouseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereIsValidated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereMonday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereSaturday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereSunday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereThursday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereTuesday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entry whereWednesday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entry withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Entry withoutTrashed()
 * @mixin \Eloquent
 */
class Entry extends Model implements AuditableContract
{

    use SoftDeletes, Auditable;

    protected $table = 'entries';

    protected $fillable = ['lat', 'lng', 'name', 'tags', 'street', 'house_number', 'postcode', 'place',
                           'url', 'phone', 'monday', 'tuesday', 'wednesday', 'thursday',
                           'friday', 'saturday', 'sunday', 'other'];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'lat', 'lng', 'name', 'tags', 'street', 'house_number', 'postcode', 'place',
        'url', 'phone', 'monday', 'tuesday', 'wednesday', 'thursday',
        'friday', 'saturday', 'sunday', 'other'
    ];

    public function getTagsAttribute($value) {

        $tags = explode(', ', $value);

        if ($tags != [""]) {
            return $tags;
        } else {
            return array();
        }

    }

    public function getIsValidatedAttribute($value) {
        return $value == 1 ? true : false;
    }

    public function events() {
        return $this->hasMany('App\Event');
    }

    public function organisations() {
        return $this->belongsToMany('App\Organisation');
    }

}
