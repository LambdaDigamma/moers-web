<?php

namespace App\Traits;

use Spatie\Translatable\HasTranslations as BaseHasTranslations;

trait SerializeTranslations
{
    use BaseHasTranslations;

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

    public function baseAttributes(): array
    {
        // Attributes selected by the query
        $attributes = $this->attributesToArray();

        // Remove attributes if they are not selected
        $translatable = array_filter($this->getTranslatableAttributes(), function ($key) use ($attributes) {
            return array_key_exists($key, $attributes);
        });

        foreach ($translatable as $field) {
            $attributes[$field] = $this->getTranslation($field, app()->getLocale());
        }

        return array_merge($attributes, $this->relationsToArray());
    }
}
