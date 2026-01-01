<?php

namespace App\Models;

use App\Traits\SerializeMedia;
use App\Traits\SerializeTranslations;
use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use LaravelArchivable\Archivable;
use LaravelPublishable\Publishable;
use Modules\Events\Models\Event;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Page extends Model implements HasMedia
{
    use Archivable;
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;
    use Publishable;
    use SerializeMedia;
    use SerializeTranslations;
    use SoftDeletes;

    protected $table = 'mm_pages';

    protected $guarded = ['*', 'id'];

    public array $translatable = ['title', 'slug', 'summary', 'keywords'];

    public $appends = ['full_slug', 'resource_url'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('header')
            ->withResponsiveImages()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('opengraph')
                    ->width(1200)
                    ->height(630)
                    ->nonQueued();
                $this
                    ->addMediaConversion('thumbnail')
                    ->width(400)
                    ->keepOriginalImageFormat()
                    ->nonQueued();
            });
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->crop(300, 300)
            ->queued();
    }

    public function resolveRouteBinding($value, $field = null): \Illuminate\Database\Eloquent\Model|Page|null
    {
        if ($field == 'slug') {
            return static::findByLocalizedSlug($value);
        } else {
            return parent::resolveRouteBinding($value, $field);
        }
    }

    public static function findByLocalizedSlug($slug)
    {
        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale', 'de');

        $page = Page::with(['media', 'blocks', 'blocks.media', 'event', 'parentMenuItem'])
            ->where("slug->${locale}", $slug)
            ->first();

        if ($page != null) {
            return $page;
        } else {
            return Page::with(['media', 'blocks', 'blocks.media', 'event', 'parentMenuItem'])
                ->where("slug->{$fallback}", $slug)
                ->firstOrFail();
        }
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'id', 'page_id');
    }

    public function blocks(): Page|HasMany
    {
        return $this
            ->hasMany(PageBlock::class)
            ->orderBy('order');
    }

    public function media(): MorphMany
    {
        return $this->morphMany(config('media-library.media_model'), 'model');
    }

    public function getResourceUrlAttribute()
    {
        return url('/').$this->getFullSlugAttribute();
    }

    public function getFullSlugAttribute(): string
    {
        $locale = app()->getLocale();

        return Str::of('/')
            ->append($locale)
            ->append('/')
            ->append($this->slug)
            ->toString();
    }

    public function toArray(): array
    {
        $attributes = parent::toArray();

        return array_merge(
            $attributes,
            $this->serializeMediaCollections(),
        );
    }

    public function scopeFilter($query, array $filters): void
    {
        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');
        $query->when($filters['search'] ?? null, function ($query, $search) use ($locale, $fallback) {
            $query
                ->where("title->$locale", 'like', '%'.$search.'%')
                ->orWhere("title->$fallback", 'like', '%'.$search.'%')
                ->orWhere("slug->$locale", 'like', '%'.$search.'%')
                ->orWhere("slug->$fallback", 'like', '%'.$search.'%');
        })->when($filters['type'] ?? null, function ($query, $type) {
            if ($type === 'drafts') {
                $query->onlyNotPublished();
            } elseif ($type === 'archived') {
                $query->onlyArchived();
            } elseif ($type === 'deleted') {
                $query->onlyTrashed();
            }
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    protected static function newFactory(): PageFactory
    {
        return PageFactory::new();
    }
}
