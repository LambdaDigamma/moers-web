<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed can_visitors_vote
 * @property mixed is_closed
 * @property mixed max_check
 * @property mixed can_voter_see_result
 * @property mixed starts_at
 */
class Poll extends Model
{

    protected $fillable = ['question', 'can_visitors_vote', 'can_voter_see_result'];
    protected $table = 'polls';
    protected $guarded = [''];

    /**
     * Returns the Group that this Poll belongs to.
     *
     * @return BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function options()
    {
        return $this->hasMany('App\PollOption');
    }

    public function canGuestVote()
    {
        return $this->can_visitors_vote === 1;
    }

    public function optionsNumber()
    {
        return $this->options()->count();
    }

    public function isRadio()
    {
        return $this->max_check == 1;
    }

    public function isCheckable()
    {
        return !$this->isRadio();
    }

    public function isLocked()
    {
        return !is_null($this->is_closed);
    }

    public function showResultsEnabled()
    {
        return !is_null($this->can_voter_see_result) && $this->can_voter_see_result == 1;
    }

    public function isOpen()
    {
        return !$this->isLocked();
    }

    public function isRunning()
    {
        return $this->isOpen() && $this->hasStarted();
    }

    public function hasStarted()
    {
        return $this->starts_at <= now();
    }

    public function isComingSoon()
    {
        return $this->isOpen() && now() < $this->starts_at;
    }

}
