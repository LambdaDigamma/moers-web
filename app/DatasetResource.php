<?php

namespace App;

use Spatie\Translatable\HasTranslations;

class DatasetResource extends Model
{

    use HasTranslations;

    public $translatable = ['name'];

    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }

}
