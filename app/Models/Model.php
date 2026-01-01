<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent
{
    protected $guarded = [];

    protected $perPage = 10;

    public function toArray(): array
    {
        $attributes = parent::toArray();

        if (method_exists($this, 'getTranslatableAttributes')) {
            foreach ($this->getTranslatableAttributes() as $name) {
                $attributes[$name] = $this->getTranslation($name, app()->getLocale());
            }
        }

        return $attributes;
    }
}
