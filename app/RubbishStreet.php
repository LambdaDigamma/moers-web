<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RubbishStreet extends Model
{

    public function scopeCurrent($query) {
        return $query->where('year', '=', Carbon::now()->year);
    }

}
