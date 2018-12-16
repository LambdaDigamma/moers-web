<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{

    use SoftDeletes;

    protected $table = 'entries';

    protected $fillable = ['lat', 'lng', 'name', 'tags', 'street', 'house_number', 'postcode',
                           'url', 'phone', 'monday', 'tuesday', 'wednesday', 'thursday',
                           'friday', 'saturday', 'sunday', 'other'];

    public function events() {
        return $this->hasMany('App\Event');
    }

    public function organisations() {
        return $this->belongsToMany('App\Organisation');
    }

}
