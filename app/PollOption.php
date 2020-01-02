<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PollOption
 *
 * @property mixed poll
 * @property int $id
 * @property string $name
 * @property int $poll_id
 * @property int $votes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Poll $poll
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PollOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PollOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PollOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PollOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PollOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PollOption whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PollOption wherePollId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PollOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PollOption whereVotes($value)
 * @mixin \Eloquent
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
