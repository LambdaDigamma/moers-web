<?php

namespace App;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class DatasetResource extends Model implements HasMedia
{

    use HasTranslations;
    use InteractsWithMedia;

    public $translatable = ['name'];

    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }

}
