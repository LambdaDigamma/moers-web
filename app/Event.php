<?php

namespace App;

use App\Models\Model;
use App\Models\Organisation;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

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
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Entry|null $entry
 * @property-read Organisation|null $organisation
 * @method static bool|null forceDelete()
 * @method static Builder|Event newModelQuery()
 * @method static Builder|Event newQuery()
 * @method static \Illuminate\Database\Query\Builder|Event onlyTrashed()
 * @method static Builder|Event query()
 * @method static bool|null restore()
 * @method static Builder|Event whereCategory($value)
 * @method static Builder|Event whereCreatedAt($value)
 * @method static Builder|Event whereDate($value)
 * @method static Builder|Event whereDeletedAt($value)
 * @method static Builder|Event whereDescription($value)
 * @method static Builder|Event whereEntryId($value)
 * @method static Builder|Event whereExtras($value)
 * @method static Builder|Event whereId($value)
 * @method static Builder|Event whereName($value)
 * @method static Builder|Event whereOrganisationId($value)
 * @method static Builder|Event whereTimeEnd($value)
 * @method static Builder|Event whereTimeStart($value)
 * @method static Builder|Event whereUpdatedAt($value)
 * @method static Builder|Event whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|Event withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Event withoutTrashed()
 * @mixin Eloquent
 */
class Event extends Model
{
    use SoftDeletes;

    protected $table = 'events';

    protected $fillable = ['name', 'date', 'time_start', 'time_end',
                           'description', 'url', 'category',
                           'organisation_id', 'entry_id', 'extras'];

    public function organisation()
    {
        return $this->belongsTo('App\Models\Organisation');
    }

    public function entry()
    {
        return $this->belongsTo('App\Entry');
    }
}
