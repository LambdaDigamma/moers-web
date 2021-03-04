<?php

namespace App;

use App\Models\Model;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Vote
 *
 * @property int $id
 * @property int $user_id
 * @property int $poll_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Vote newModelQuery()
 * @method static Builder|Vote newQuery()
 * @method static Builder|Vote query()
 * @method static Builder|Vote whereCreatedAt($value)
 * @method static Builder|Vote whereId($value)
 * @method static Builder|Vote wherePollId($value)
 * @method static Builder|Vote whereUpdatedAt($value)
 * @method static Builder|Vote whereUserId($value)
 * @mixin Eloquent
 * @property-read Poll $poll
 * @property-read User|null $user
 */
class Vote extends Model
{

    protected $table = 'votes';
    protected $fillable = ['poll_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

}
