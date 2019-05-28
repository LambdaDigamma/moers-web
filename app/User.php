<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;

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
    protected $fillable = ['name', 'email', 'password'];

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

}
