<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Translatable\HasTranslations;

class PageBlock extends Model
{
    use SoftDeletes;
    use HasMediaTrait;
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
