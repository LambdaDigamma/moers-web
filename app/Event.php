<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{

    use SoftDeletes;

    protected $table = 'events';

    protected $fillable = ['name', 'date', 'time_start', 'time_end',
                           'description', 'url', 'category',
                           'organisation_id', 'entry_id', 'extras'];

    public function organisation() {
        return $this->belongsTo('App\Organisation');
    }

    public function entry() {
        return $this->belongsTo('App\Entry');
    }

}
