<?php

namespace Modules\Organisation\Models;

use App\Models\AdvEvent;
use App\Models\Entry;
use App\Models\Group;
use App\Models\Model;
use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Modules\Organisation\Database\Factories\OrganisationFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Organisation
 *
 * @property integer|null                                                                                       group_id
 * @property int                                                                                                $id
 * @property string                                                                                             $name
 * @property string                                                                                             $description
 * @property int|null                                                                                           $entry_id
 * @property string|null                                                                                        $tags
 * @property string|null                                                                                        $logo_url
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
 * @property-read mixed                                                                                         $header_path
 * @property-read mixed                                                                                         $logo_path
 * @property-read \App\Models\Group                                                                             $mainGroup
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null                                                                                      $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdvEvent[]                               $publishedEvents
 * @property-read int|null                                                                                      $published_events_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Organisation filter($filters)
 */
class Organisation extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;

    protected $table = 'organisations';
    protected $fillable = ['name', 'description'];
    protected $appends = ['header_path', 'logo_path'];

    protected static function newFactory(): OrganisationFactory
    {
        return OrganisationFactory::new();
    }

    public function users(): BelongsToMany
    {
        return $this
            ->belongsToMany(User::class)
            ->withPivot('organisation_id', 'user_id', 'role');
    }

    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }

    // TODO: Only show next events
    public function events()
    {
        return $this->hasMany(AdvEvent::class);
    }

    public function publishedEvents()
    {
        return $this->hasMany(AdvEvent::class)->published();
    }

    /**
     * Returns the Main Group or null if none is set.
     *
     * @return HasOne|null
     */
    public function mainGroup()
    {
        return $this->hasOne(Group::class);
    }

    public function getHeaderPathAttribute()
    {
        if (!is_null($this->getFirstMedia('header'))) {
            return $this->getFirstMedia('header')->getUrl();
        }
    }

    public function getLogoPathAttribute()
    {
        if (!is_null($this->getFirstMedia('logo'))) {
            return $this->getFirstMedia('logo')->getUrl();
        }
    }

    /* Custom Scopes */

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
