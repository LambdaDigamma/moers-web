<?php

namespace App;

use Auth;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Laravel\Passport\Client;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Token;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Silber\Bouncer\Database\Role;

/**
 * App\User
 *
 * @property mixed email
 * @property mixed name
 * @property string password
 * @method static findOrFail($get)
 * @property int $id
 * @property string|null $description
 * @property int $points
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Ability[] $abilities
 * @property-read int|null $abilities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Group[] $groups
 * @property-read int|null $groups_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Organisation[] $organisations
 * @property-read int|null $organisations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDescription($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIs($role)
 * @method static Builder|User whereIsAll($role)
 * @method static Builder|User whereIsNot($role)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePoints($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
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
    protected $fillable = ['name', 'email', 'description', 'provider_id', 'provider'];

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
     * Returns a Query Builder of all Polls that the User is allowed to see and answer.
     * The Polls also include their PollOptions.
     *
     * @return Builder
     */
    public function polls()
    {
        return Poll::with(['group', 'group.organisation'])
            ->whereHas('group', function ($query) {
                $query->whereHas('users', function ($query) {
                    $query->where('id', Auth::user()->id);
                });
            });
    }


}
