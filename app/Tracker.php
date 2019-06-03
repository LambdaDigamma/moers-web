<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{

    protected $casts = [
        'is_enabled' => 'boolean',
    ];
    
}
