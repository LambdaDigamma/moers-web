<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Models\Audit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Entry
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
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read Collection|Event[] $events
 * @property-read int|null $events_count
 * @property-read Collection|Organisation[] $organisations
 * @property-read int|null $organisations_count
 * @method static bool|null forceDelete()
 * @method static Builder|Entry newModelQuery()
 * @method static Builder|Entry newQuery()
 * @method static Builder|Entry onlyTrashed()
 * @method static Builder|Entry query()
 * @method static bool|null restore()
 * @method static Builder|Entry whereCreatedAt($value)
 * @method static Builder|Entry whereDeletedAt($value)
 * @method static Builder|Entry whereFriday($value)
 * @method static Builder|Entry whereHouseNumber($value)
 * @method static Builder|Entry whereId($value)
 * @method static Builder|Entry whereIsValidated($value)
 * @method static Builder|Entry whereLat($value)
 * @method static Builder|Entry whereLng($value)
 * @method static Builder|Entry whereMonday($value)
 * @method static Builder|Entry whereName($value)
 * @method static Builder|Entry whereOther($value)
 * @method static Builder|Entry wherePhone($value)
 * @method static Builder|Entry wherePlace($value)
 * @method static Builder|Entry wherePostcode($value)
 * @method static Builder|Entry whereSaturday($value)
 * @method static Builder|Entry whereStreet($value)
 * @method static Builder|Entry whereSunday($value)
 * @method static Builder|Entry whereTags($value)
 * @method static Builder|Entry whereThursday($value)
 * @method static Builder|Entry whereTuesday($value)
 * @method static Builder|Entry whereUpdatedAt($value)
 * @method static Builder|Entry whereUrl($value)
 * @method static Builder|Entry whereUserId($value)
 * @method static Builder|Entry whereWednesday($value)
 * @method static Builder|Entry withTrashed()
 * @method static Builder|Entry withoutTrashed()
 * @mixin Eloquent
 * @property-read mixed $header_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Entry filter(array $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry validated()
 */
class Entry extends Model implements AuditableContract, HasMedia
{
    use SoftDeletes, Auditable, InteractsWithMedia, HasFactory;

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

    protected $appends = ['header_url'];

    public function getHeaderUrlAttribute()
    {
        if (!is_null($this->getFirstMedia('header'))) {
            return $this->getFirstMedia('header')->getUrl();
        }
    }

    public function getTagsAttribute($value)
    {
        $tags = explode(', ', $value);

        if ($tags != [""]) {
            return $tags;
        } else {
            return array();
        }
    }

    public function getIsValidatedAttribute($value)
    {
        return $value == 1 ? true : false;
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function organisations()
    {
        return $this->hasMany(Organisation::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('street', 'like', '%' . $search . '%')
                ->orWhere('tags', 'like', '%' . $search . '%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    public function scopeValidated($query)
    {
        return $query->where('is_validated', '=', true);
    }
}
