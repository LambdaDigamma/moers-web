<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Event
 *
 * @property int $id
 * @property string $name
 * @property string $date
 * @property string $time_start
 * @property string|null $time_end
 * @property string|null $description
 * @property string|null $url
 * @property string|null $category
 * @property int|null $organisation_id
 * @property int|null $entry_id
 * @property mixed|null $extras
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Entry|null $entry
 * @property-read \App\Organisation|null $organisation
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Event onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereExtras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereOrganisationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereTimeEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereTimeStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Event withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Event withoutTrashed()
 * @mixin \Eloquent
 */
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
