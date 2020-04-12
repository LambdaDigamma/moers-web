<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Spatie\Translatable\HasTranslations;

abstract class Model extends Eloquent
{
    protected $guarded = [];

    protected $perPage = 10;

    public function resolveRouteBinding($value, $field = null)
    {
        return in_array(SoftDeletes::class, class_uses($this))
            ? $this->where($this->getRouteKeyName(), $value)->withTrashed()->first()
            : parent::resolveRouteBinding($value);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function toArray()
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
