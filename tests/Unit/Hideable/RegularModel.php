<?php

namespace Tests\Unit\Hideable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegularModel extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return RegularModelFactory::new();
    }
}
