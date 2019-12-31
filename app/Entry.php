<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Entry extends Model implements AuditableContract
{

    use SoftDeletes, Auditable;

    protected $table = 'entries';

    protected $fillable = ['lat', 'lng', 'name', 'tags', 'street', 'house_number', 'postcode', 'place',
                           'url', 'phone', 'monday', 'tuesday', 'wednesday', 'thursday',
                           'friday', 'saturday', 'sunday', 'other'];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'lat', 'lng', 'name', 'tags', 'street', 'house_number', 'postcode', 'place',
        'url', 'phone', 'monday', 'tuesday', 'wednesday', 'thursday',
        'friday', 'saturday', 'sunday', 'other'
    ];

    public function getTagsAttribute($value) {

        $tags = explode(', ', $value);

        if ($tags != [""]) {
            return $tags;
        } else {
            return array();
        }

    }

    public function getIsValidatedAttribute($value) {
        return $value == 1 ? true : false;
    }

    public function events() {
        return $this->hasMany('App\Event');
    }

    public function organisations() {
        return $this->belongsToMany('App\Organisation');
    }

}
