<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * App\PageBlock
 *
 * @property int $id
 * @property int $page_id
 * @property string $type
 * @property array $data
 * @property int|null $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Page $page
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageBlock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageBlock newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\PageBlock onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageBlock query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageBlock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageBlock whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageBlock whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageBlock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageBlock whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageBlock wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageBlock whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PageBlock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PageBlock withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\PageBlock withoutTrashed()
 * @mixin \Eloquent
 */
class PageBlock extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasTranslations;

    protected $guarded = [];

    protected $casts = [
        'data' => 'array'
    ];

    public $translatable = ['data'];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
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
