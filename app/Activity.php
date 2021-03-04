<?php

namespace App;

use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Activity
 *
 * @property int $id
 * @property int $user_id
 * @property string $associated_table_name
 * @property int $associated_object_index
 * @property string $origin_value
 * @property string $new_value
 * @property int $reward
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Activity newModelQuery()
 * @method static Builder|Activity newQuery()
 * @method static Builder|Activity query()
 * @method static Builder|Activity whereAssociatedObjectIndex($value)
 * @method static Builder|Activity whereAssociatedTableName($value)
 * @method static Builder|Activity whereCreatedAt($value)
 * @method static Builder|Activity whereDescription($value)
 * @method static Builder|Activity whereId($value)
 * @method static Builder|Activity whereNewValue($value)
 * @method static Builder|Activity whereOriginValue($value)
 * @method static Builder|Activity whereReward($value)
 * @method static Builder|Activity whereUpdatedAt($value)
 * @method static Builder|Activity whereUserId($value)
 * @mixin Eloquent
 */
class Activity extends Model
{
    public function user()
    {
        return User::where('user_id', '=', $this->user_id)->firstOrFail();
    }
}
