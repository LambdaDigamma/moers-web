<?php

namespace Modules\Locations\Models;

use App\Models\Page;
use App\Traits\SerializeTranslations;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Events\Models\Event;
use Modules\Locations\Database\factories\LocationFactory;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Location extends Model
{
    use InteractsWithMedia;
    use HasFactory;
    use HasTranslations;
    use SerializeTranslations;
    use SoftDeletes;

    protected $table = 'locations';

    protected $guarded = ['*', 'id'];

    protected array $translatable = ['name', 'tags'];

    protected $casts = [
        'tags' => 'array',
        'extras' => 'array',
        'validated_at' => 'datetime',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id', 'id', 'mm_pages');
    }

    public function events(): Location|HasMany
    {
        return $this->hasMany(related: Event::class, foreignKey: 'place_id', localKey: 'id');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('street_name', 'like', '%'.$search.'%');
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
        return $query->where('validated_at', '!=', null);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('header')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('opengraph')
                    ->width(1200)
                    ->height(630);
            });
    }

    public function jsonLd(): array
    {
        return [
            '@type' => 'Place',
            'name' => $this->name,
            'latitude' => $this->lat,
            'longitude' => $this->lng,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => ($this->street_name ?? '') . ' ' . ($this->street_number ?? ''),
                'addressLocality' => $this->postal_town,
                'postalCode' => $this->postalcode,
                'addressCountry' => $this->country_code
            ]
        ];
    }

    public static function newFactory(): LocationFactory
    {
        return LocationFactory::new();
    }
}
