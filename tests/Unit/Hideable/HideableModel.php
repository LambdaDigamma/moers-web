<?php

namespace Tests\Unit\Hideable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LambdaDigamma\MMPages\Traits\Hideable;

class HideableModel extends Model
{
    use HasFactory;
    use Hideable;

    protected static function newFactory(): HideableModelFactory
    {
        return HideableModelFactory::new();
    }
}
