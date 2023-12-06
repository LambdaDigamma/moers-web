<?php


namespace App\Traits;

use Spatie\Translatable\HasTranslations;

trait SerializeTranslations
{
    use HasTranslations;

    public function toArray()
    {
        $attributes = parent::toArray();

        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, app()->getLocale());
        }

        return $attributes;
    }
}
