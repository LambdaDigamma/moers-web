<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\Quarter
 *
 * @property int $id
 * @property string $name
 * @property string $postcode
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Quarter newModelQuery()
 * @method static Builder|Quarter newQuery()
 * @method static Builder|Quarter query()
 * @method static Builder|Quarter whereCreatedAt($value)
 * @method static Builder|Quarter whereId($value)
 * @method static Builder|Quarter whereName($value)
 * @method static Builder|Quarter wherePostcode($value)
 * @method static Builder|Quarter whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Quarter extends Model
{
    //
}
