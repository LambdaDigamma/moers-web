<?php

namespace App;

use App\Models\Group;
use App\Models\Model;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Poll
 *
 * @property mixed id
 * @property mixed can_visitors_vote
 * @property mixed is_closed
 * @property mixed max_check
 * @property mixed can_voter_see_result
 * @property mixed starts_at
 * @property string $question
 * @property string $description
 * @property int|null $group_id
 * @property string|null $ends_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $has_started
 * @property-read mixed $has_user_vote
 * @property-read mixed $is_coming_soon
 * @property-read mixed $is_locked
 * @property-read mixed $is_open
 * @property-read mixed $is_radio
 * @property-read mixed $is_running
 * @property-read mixed $results
 * @property-read mixed $show_results_enabled
 * @property-read Group|null $group
 * @property-read Collection|PollOption[] $options
 * @property-read int|null $options_count
 * @property-read Collection|Vote[] $votes
 * @property-read int|null $votes_count
 * @method static Builder|Poll newModelQuery()
 * @method static Builder|Poll newQuery()
 * @method static Builder|Poll query()
 * @method static Builder|Poll whereCanVisitorsVote($value)
 * @method static Builder|Poll whereCanVoterSeeResult($value)
 * @method static Builder|Poll whereCreatedAt($value)
 * @method static Builder|Poll whereDescription($value)
 * @method static Builder|Poll whereEndsAt($value)
 * @method static Builder|Poll whereGroupId($value)
 * @method static Builder|Poll whereId($value)
 * @method static Builder|Poll whereIsClosed($value)
 * @method static Builder|Poll whereMaxCheck($value)
 * @method static Builder|Poll whereQuestion($value)
 * @method static Builder|Poll whereStartsAt($value)
 * @method static Builder|Poll whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $id
 * @property int $max_check
 * @property int $can_visitors_vote
 * @property int $can_voter_see_result
 * @property string|null $is_closed
 * @property string|null $starts_at
 * @method static Builder|Poll answered()
 * @method static Builder|Poll filter($filters)
 * @method static Builder|Poll unanswered()
 */
class Poll extends Model
{

    protected $fillable = [
        'question',
        'description',
        'max_check',
        'group_id',
        'can_visitors_vote',
        'can_voter_see_result'
    ];
    protected $table = 'polls';
    protected $guarded = [''];
    protected $appends = ['has_user_vote', 'is_radio', 'is_locked', 'is_open', 'show_results_enabled', 'is_running',
                          'has_started', 'is_coming_soon', 'results'];

    /**
     * Returns the Group that this Poll belongs to.
     *
     * @return BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('App\Models\Group');
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

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }

    public function results()
    {
        $votes = $this->options()->select(['id', 'name', 'votes'])->orderByDesc('votes')->get();
        $total = $this->totalVotes();
        $totalAbstentions = $this->totalAbstentions();

        $votes->push(['name' => 'Enthaltung', 'votes' => $totalAbstentions]);

        return collect([
            'votes' => $votes,
            'total' => $total,
            'totalAbstentions' => $this->totalAbstentions()
        ]);
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
     * Returns whether the currently authenticated User has access to the group to answer this Poll.
     *
     * @return bool
     */
    public function canUserVote()
    {
        return $this->group->users->contains(Auth::user());
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

    /**
     * Returns the number of total votes by Users.
     *
     * @return int
     */
    public function totalVotes()
    {
        return $this->votes()->count();
    }

    /**
     * Returns the number of total abstentions.
     *
     * @return int
     */
    public function totalAbstentions()
    {
        $realVotes = $this->options()->get()->reduce(function ($carry, $item) {
            return $carry + $item->votes;
        }, 0) / $this->max_check;

        return $this->totalVotes() - $realVotes;
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('question', 'like', '%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    public function scopeAnswered($query)
    {
        $query->whereHas('votes', function ($query) {
            $query->whereHas('user', function ($query) {
                $query->where('id', Auth::user()->id);
            });
        });
    }

    public function scopeUnanswered($query)
    {

        $query->whereDoesntHave('votes', function ($query) {
            $query->whereHas('user', function ($query) {
                $query->where('id', Auth::user()->id);
            });
        });

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
            return $this->results();
        } else {
            return null;
        }
    }

}
