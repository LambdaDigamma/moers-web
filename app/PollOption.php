<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed poll
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
