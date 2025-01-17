<?php

namespace Modules\News\Models;

use App\Traits\SerializeMedia;
use App\Traits\SerializeTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelArchivable\Archivable;
use LaravelPublishable\Publishable;
use Modules\News\Database\Factories\PostFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use SoftDeletes;
    use HasFactory;
    use Archivable;
    use Publishable;
    use SerializeTranslations;
    use SerializeMedia;
    use InteractsWithMedia;

    protected $table = "posts";
    protected $guarded = ['*', 'id'];
    public array $translatable = ['title', 'summary', 'slug', 'external_href'];
    protected $appends = ['cta'];
    protected $casts = [
        'extras' => AsCollection::class,
    ];

    /**
     * @return BelongsToMany
     */
    public function feeds(): BelongsToMany
    {
        return $this
            ->belongsToMany(Feed::class, 'publications', 'post_id', 'feed_id')
            ->as('publication')
            ->using(Publication::class)
            ->orderByPivot('order');
    }

    /**
     * Orders the query with a chronological published date.
     * Events without a start date go last.
     */
    public function scopeChronological(Builder $query): Builder
    {
        if (config('database.default') === 'pgsql') {
            return $query
                ->orderByRaw('published_at ASC NULLS LAST');
        } else {
            return $query
                ->orderByRaw('-published_at ASC');
        }
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('header')
            ->singleFile()
            ->withResponsiveImages()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('opengraph')
                    ->width(1200)
                    ->height(630);
            });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->crop(300, 300)
            ->nonQueued();
    }

    public function getCtaAttribute()
    {
        return $this->extras ? $this->extras->get('cta', 'read') : "read";
    }

    public function setCtaAttribute($value): void
    {
        if ($this->extras) {
            $this->extras->put('cta', $value);
        } else {
            $this->extras = collect(['cta' => $value]);
        }
    }

    public function toArray(): array
    {
        $attributes = parent::toArray();

        return array_merge(
            $attributes,
            $this->serializeMediaCollections(),
            $this->serializeTranslations(),
        );
    }

    public static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }
}
