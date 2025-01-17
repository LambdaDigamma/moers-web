<?php

namespace App\Traits;

use Spatie\Translatable\HasTranslations;

trait SerializeTranslations
{
    use HasTranslations;

    public function toArray(): array
    {
        $attributes = parent::toArray();

        return $this->serializeTranslations($attributes);
    }

    public function serializeTranslations($attributes = []): array
    {
        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, app()->getLocale());
        }

        return $attributes;
    }
}
