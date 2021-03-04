<?php

namespace App\Models;

use App\Traits\SerializeTranslations;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\PageBlock
 *
 * @property int $id
 * @property int $page_id
 * @property string $type
 * @property array $data
 * @property int|null $order
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $translations
 * @property-read Collection|Media[] $media
 * @property-read int|null $media_count
 * @property-read Page $page
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock newQuery()
 * @method static Builder|PageBlock onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageBlock whereUpdatedAt($value)
 * @method static Builder|PageBlock withTrashed()
 * @method static Builder|PageBlock withoutTrashed()
 * @mixin Eloquent
 */
class PageBlock extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use SerializeTranslations;

    protected $guarded = [];
    public $translatable = ['data'];
    protected $casts = ['data' => 'array'];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

}
