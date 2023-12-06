<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\Tracker
 *
 * @property int $id
 * @property string $device_id
 * @property string|null $name
 * @property string|null $description
 * @property bool $is_enabled
 * @property string|null $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Tracker newModelQuery()
 * @method static Builder|Tracker newQuery()
 * @method static Builder|Tracker query()
 * @method static Builder|Tracker whereCreatedAt($value)
 * @method static Builder|Tracker whereDescription($value)
 * @method static Builder|Tracker whereDeviceId($value)
 * @method static Builder|Tracker whereId($value)
 * @method static Builder|Tracker whereIsEnabled($value)
 * @method static Builder|Tracker whereName($value)
 * @method static Builder|Tracker whereType($value)
 * @method static Builder|Tracker whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Tracker extends Model
{

    protected $casts = [
        'is_enabled' => 'boolean',
    ];
    
}
