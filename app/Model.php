<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @mixin \Eloquent
 */
abstract class Model extends Eloquent
{
    protected $guarded = [];

    protected $perPage = 10;

    public function resolveRouteBinding($value, $field = NULL)
    {
        return in_array(SoftDeletes::class, class_uses($this))
            ? $this->where($this->getRouteKeyName(), $value)->withTrashed()->first()
            : parent::resolveRouteBinding($value);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
