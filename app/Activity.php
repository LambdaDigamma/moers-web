<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereAssociatedObjectIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereAssociatedTableName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereNewValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereOriginValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereUserId($value)
 * @mixin \Eloquent
 */
class Activity extends Model
{

    public function user() {

        return User::where('user_id', '=', $this->user_id)->firstOrFail();

    }

}
