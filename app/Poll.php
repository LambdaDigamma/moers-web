<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * @property mixed id
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
    protected $appends = ['has_user_vote', 'is_radio', 'is_locked', 'is_open', 'show_results_enabled', 'is_running', 'has_started', 'is_coming_soon', 'results'];

    /**
     * Returns the Group that this Poll belongs to.
     *
     * @return BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    /**
     * Returns all associated Options for this Poll.
     *
     * @return HasMany
     */
    public function options()
    {
        return $this->hasMany('App\PollOption');
    }

    /**
     * Return whether the currently authenticated User has already answered this Poll.
     *
     * @return bool
     */
    public function hasUserVote()
    {
        $user_id = Auth::user()->id;
        return Vote::where([
            ['user_id', $user_id],
            ['poll_id', $this->id]
        ])->count() == 1;
    }

    /**
     * Returns whether this Poll can be answered by guests.
     *
     * @return bool
     */
    public function canGuestVote()
    {
        return $this->can_visitors_vote === 1;
    }

    /**
     * Returns whether this Poll should have a radio style voting.
     *
     * @return bool
     */
    public function isRadio()
    {
        return $this->max_check == 1;
    }

    /**
     * Returns whether this Poll should have multiple choice voting.
     *
     * @return bool
     */
    public function isCheckable()
    {
        return !$this->isRadio();
    }

    /**
     * Returns whether this Poll is locked due to being closed.
     *
     * @return bool
     */
    public function isLocked()
    {
        return !is_null($this->is_closed);
    }

    /**
     * Returns whether this Poll is open for voting.
     *
     * @return bool
     */
    public function isOpen()
    {
        return !$this->isLocked();
    }

    /**
     * Returns whether a User is allowed to see the results.
     *
     * @return bool
     */
    public function showResultsEnabled()
    {
        return !is_null($this->can_voter_see_result) && $this->can_voter_see_result == 1;
    }

    /**
     * Returns whether this Poll is currently running.
     * That means it is open and has started.
     *
     * @return bool
     */
    public function isRunning()
    {
        return $this->isOpen() && $this->hasStarted();
    }

    /**
     * Retuns whether this Poll has already started.
     *
     * @return bool
     */
    public function hasStarted()
    {
        return $this->starts_at <= now();
    }

    /**
     * Returns whether this poll will be opened soon.
     * That means that it is open but has not started yet.
     *
     * @return bool
     */
    public function isComingSoon()
    {
        return $this->isOpen() && now() < $this->starts_at;
    }

    /* Attributes */

    public function getHasUserVoteAttribute()
    {
        return $this->hasUserVote();
    }

    public function getIsRadioAttribute()
    {
        return $this->isRadio();
    }

    public function getIsLockedAttribute()
    {
        return $this->isLocked();
    }

    public function getIsOpenAttribute()
    {
        return $this->isOpen();
    }

    public function getShowResultsEnabledAttribute()
    {
        return $this->showResultsEnabled();
    }

    public function getIsRunningAttribute()
    {
        return $this->isRunning();
    }

    public function getHasStartedAttribute()
    {
        return $this->hasStarted();
    }

    public function getIsComingSoonAttribute()
    {
        return $this->isComingSoon();
    }

    public function getResultsAttribute()
    {
        if ($this->hasUserVote()) {

            $votes = $this->options()->select(['id', 'name', 'votes'])->get();

            $total = $votes->reduce(function ($carry, $vote) {
                return $carry + $vote->votes;
            });

            return ['votes' => $votes, 'total' => $total];

        } else {
            return null;
        }
    }

}
