<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Tracker
 *
 * @property int $id
 * @property string $device_id
 * @property string|null $name
 * @property string|null $description
 * @property bool $is_enabled
 * @property string|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tracker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tracker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tracker query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tracker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tracker whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tracker whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tracker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tracker whereIsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tracker whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tracker whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tracker whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tracker extends Model
{

    protected $casts = [
        'is_enabled' => 'boolean',
    ];
    
}
