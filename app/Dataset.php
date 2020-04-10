<?php

namespace App;

use Spatie\Translatable\HasTranslations;

class Dataset extends Model
{

    use HasTranslations;

    public $translatable = ['name'];

    public function resources()
    {
        return $this->hasMany(DatasetResource::class)->orderByDesc('updated_at');
    }

    public function getCategoriesAttribute($value) {

        $categories = explode(', ', $value);

        if ($categories != [""]) {
            return $categories;
        } else {
            return array();
        }

    }

}
