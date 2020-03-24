<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * App\Page
 *
 * @property int $id
 * @property array $title
 * @property array $slug
 * @property int|null $creator_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PageBlock[] $blocks
 * @property-read int|null $blocks_count
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page filter($filters)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Page onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Page withoutTrashed()
 * @mixin \Eloquent
 */
class Page extends Model
{
    use SoftDeletes;
    use HasTranslations;

    public $translatable = ['title', 'slug'];

    public function blocks()
    {
        return $this
            ->hasMany(PageBlock::class, 'page_id', 'id')
            ->orderBy('order');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('title', 'like', '%'.$search.'%');
            $query->where('slug', 'like', '%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
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
