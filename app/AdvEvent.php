<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * App\AdvEvent
 *
 * @property int $id
 * @property string $name
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $description
 * @property string|null $url
 * @property string|null $image_path
 * @property string|null $category
 * @property int|null $organisation_id
 * @property int|null $entry_id
 * @property int $is_published
 * @property array|null $extras
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Entry|null $entry
 * @property-read Organisation|null $organisation
 * @method static bool|null forceDelete()
 * @method static Builder|AdvEvent newModelQuery()
 * @method static Builder|AdvEvent newQuery()
 * @method static \Illuminate\Database\Query\Builder|AdvEvent onlyTrashed()
 * @method static Builder|AdvEvent query()
 * @method static bool|null restore()
 * @method static Builder|AdvEvent whereCategory($value)
 * @method static Builder|AdvEvent whereCreatedAt($value)
 * @method static Builder|AdvEvent whereDeletedAt($value)
 * @method static Builder|AdvEvent whereDescription($value)
 * @method static Builder|AdvEvent whereEndDate($value)
 * @method static Builder|AdvEvent whereEntryId($value)
 * @method static Builder|AdvEvent whereExtras($value)
 * @method static Builder|AdvEvent whereId($value)
 * @method static Builder|AdvEvent whereImagePath($value)
 * @method static Builder|AdvEvent whereIsPublished($value)
 * @method static Builder|AdvEvent whereName($value)
 * @method static Builder|AdvEvent whereOrganisationId($value)
 * @method static Builder|AdvEvent whereStartDate($value)
 * @method static Builder|AdvEvent whereUpdatedAt($value)
 * @method static Builder|AdvEvent whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|AdvEvent withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AdvEvent withoutTrashed()
 * @mixin Eloquent
 */
class AdvEvent extends Model implements HasMedia
{

    use HasTranslations;
    use InteractsWithMedia;

    protected $table = 'adv_events';

    protected $fillable = ['name', 'start_date', 'end_date',
        'description', 'url', 'image_path', 'category',
        'organisation_id', 'entry_id', 'extras', 'is_published'];

    protected $casts = [
        'extras' => 'array'
    ];

    protected $appends = ['header_url'];

    public $translatable = ['name', 'description', 'category'];

    public function getHeaderUrlAttribute()
    {
        if (!is_null($this->getFirstMedia('header'))) {
            return $this->getFirstMedia('header')->getUrl();
        }
    }

    public function organisation() {
        return $this->belongsTo('App\Organisation');
    }

    public function entry()
    {
        return $this->belongsTo('App\Entry');
    }

    public function page()
    {
        return $this->belongsTo('App\Page');
    }

    public function toArray()
    {
        $attributes = parent::toArray();

        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, app()->getLocale());
        }

        return $attributes;
    }

}
