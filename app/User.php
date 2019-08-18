<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Passport\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;

/**
 * @property mixed email
 * @property mixed name
 * @property string password
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRolesAndAbilities;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'description'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $hashable = ['password'];

    public function organisations() {
        return $this->belongsToMany('App\Organisation')->withPivot('organisation_id', 'user_id', 'role');
    }

    public function organisationRole($organisationID) {
        return $this->organisations()->findOrFail($organisationID)->pivot->role;
    }

    public function isMember($id) {
        return $this->organisations()->find($id) != null;
    }

    public function isOrganisationAdmin($organisation) {
        return $this->organisationRole($organisation->id) == 'admin';
    }

    public function makeAdmin($id) {

        $pivot = $this->organisations()->findOrFail($id)->pivot;

        $pivot->role = 'admin';
        $pivot->save();

        return $pivot;

    }

    public function makeMember($id) {

        $pivot = $this->organisations()->findOrFail($id)->pivot;

        $pivot->role = 'member';
        $pivot->save();

        return $pivot;

    }

    public function join($id) {

        if (!$this->isMember($id)) {

            $organisation = Organisation::with(['users:id,name,created_at,updated_at', 'entry'])->findOrFail($id);
            $organisation->users()->attach($this->id);

            return true;

        } else {

            return false;

        }

    }

    /**
     * Returns all Groups that the User belongs to.
     *
     * @return BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }

    /**
     * Returns a collection of all Polls that the User is allowed to see and answer.
     * The Polls also include their PollOptions.
     *
     * @return Collection
     */
    public function polls()
    {
        $groups = $this->groups()->get();

        $polls = collect([]);

        foreach($groups as $group) {
            foreach($group->polls()->with('group')->get() as $poll) {
                $polls->push($poll);
            }
        }

        return $polls;
    }


}
