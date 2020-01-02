<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\AdvEvent
 *
 * @property int $id
 * @property string $name
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $description
 * @property string|null $url
 * @property string|null $image_path
 * @property string|null $category
 * @property int|null $organisation_id
 * @property int|null $entry_id
 * @property int $is_published
 * @property array|null $extras
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Entry|null $entry
 * @property-read \App\Organisation|null $organisation
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\AdvEvent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent whereEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent whereExtras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent whereOrganisationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AdvEvent whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AdvEvent withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\AdvEvent withoutTrashed()
 * @mixin \Eloquent
 */
class AdvEvent extends Model
{

    use SoftDeletes;

    protected $table = 'adv_events';

    protected $fillable = ['name', 'date', 'start_date', 'end_date',
        'description', 'url', 'image_path', 'category',
        'organisation_id', 'entry_id', 'extras', 'is_published'];

    protected $casts = [
        'extras' => 'array'
    ];

    public function organisation() {
        return $this->belongsTo('App\Organisation');
    }

    public function entry() {
        return $this->belongsTo('App\Entry');
    }

}
