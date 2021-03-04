<?php

namespace App;

use App\Models\Model;
use App\Models\Poll;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\PollOption
 *
 * @property mixed poll
 * @property int $id
 * @property string $name
 * @property int $poll_id
 * @property int $votes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Poll $poll
 * @method static Builder|PollOption newModelQuery()
 * @method static Builder|PollOption newQuery()
 * @method static Builder|PollOption query()
 * @method static Builder|PollOption whereCreatedAt($value)
 * @method static Builder|PollOption whereId($value)
 * @method static Builder|PollOption whereName($value)
 * @method static Builder|PollOption wherePollId($value)
 * @method static Builder|PollOption whereUpdatedAt($value)
 * @method static Builder|PollOption whereVotes($value)
 * @mixin Eloquent
 */
class PollOption extends Model
{

    protected $fillable = ['name', 'poll_id'];
    protected $table = 'poll_options';

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function isPollClosed()
    {
        return $this->poll->isLocked();
    }

}
