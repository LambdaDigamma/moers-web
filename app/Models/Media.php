<?php

namespace App\Models;

use App\Traits\SerializeTranslations;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    use SerializeTranslations;

    protected array $translatable = ['alt', 'credits', 'caption'];

    protected $guarded = ['*', 'id'];

    protected $appends = ['srcset', 'full_url', 'responsive_width', 'responsive_height', 'preview_url'];

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query
                ->where('uuid', 'like', '%'.$search.'%')
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orWhere('file_name', 'like', '%'.$search.'%');
        });
    }

    // MARK: - Attributes -

    protected function srcset(): Attribute
    {
        return Attribute::get(fn () => $this->getSrcset());
    }

    protected function fullUrl(): Attribute
    {
        return Attribute::get(fn () => $this->getFullUrl());
    }

    protected function responsiveWidth(): Attribute
    {
        return Attribute::get(fn () => $this->hasResponsiveImages()
            ? $this->responsiveImages()->files->first()->width()
            : null);
    }

    protected function previewUrl(): Attribute
    {
        return Attribute::get(fn () => $this->hasGeneratedConversion('preview')
            ? $this->getUrl('preview')
            : '');
    }

    protected function responsiveHeight(): Attribute
    {
        return Attribute::get(fn () => $this->hasResponsiveImages()
            ? $this->responsiveImages()->files->first()->height()
            : null);
    }
}
