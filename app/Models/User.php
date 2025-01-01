<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Modules\Organisation\Models\Organisation;
use OwenIt\Auditing\Models\Audit;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Spatie\PersonalDataExport\ExportsPersonalData;
use Spatie\PersonalDataExport\PersonalDataSelection;

//use Laravel\Fortify\TwoFactorAuthenticatable;
//use Laravel\Jetstream\HasProfilePhoto;

class User extends Authenticatable implements ExportsPersonalData
{
    use Notifiable;
    use HasApiTokens;
    use HasFactory;
//    use HasProfilePhoto;
    use HasRolesAndAbilities;
//    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'description',
        'password',
        'provider_id',
        'provider'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'name',
        'last_name',
        'email',
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

//    protected $hashable = ['password']; // TODO: Check this.

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Conversations associated with this user.
     *
     * @return BelongsToMany
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class)
            ->withPivot('last_active', 'is_unread')
            ->withTimestamps();
    }

    public function organisations()
    {
        return $this
            ->belongsToMany(Organisation::class)
            ->withPivot('organisation_id', 'user_id', 'role');
    }

    public function organisationRole($organisationID)
    {
        return $this->organisations()->findOrFail($organisationID)->pivot->role;
    }

    public function isMember($id)
    {
        return $this->organisations()->find($id) != null;
    }

    public function isOrganisationAdmin($organisation)
    {
        return $this->organisationRole($organisation->id) == 'admin';
    }

    public function makeAdmin($id)
    {
        $pivot = $this->organisations()->findOrFail($id)->pivot;

        $pivot->role = 'admin';
        $pivot->save();

        return $pivot;
    }

    public function makeMember($id)
    {
        $pivot = $this->organisations()->findOrFail($id)->pivot;

        $pivot->role = 'member';
        $pivot->save();

        return $pivot;
    }

    public function join($id)
    {
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
        return $this->belongsToMany(Group::class);
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

    public function helpRequests()
    {
        return $this->hasMany(HelpRequest::class, 'creator_id', 'id');
    }

    public function studentInformation()
    {
        return $this->hasOne(StudentInformation::class, 'user_id', 'id');
    }

    public function selectPersonalData(PersonalDataSelection $personalDataSelection): void
    {
        // TODO: Export Memberships of Conversations?
        $user_id = $this->id;
        $personalDataSelection
            ->add('user.json', [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'description' => $this->description,
                'points' => $this->points
            ])
            ->add(
                'own_help_requests.json',
                $this->helpRequests()->get()
            )
            ->add(
                'helper_helping_requests.json',
                HelpRequest::userHelps()->get() // TODO: Change this
            )
            ->add(
                'messages.json',
                Message::where('sender_id', '=', $user_id)->get()
            )
            ->add(
                'audits.json',
                Audit::where('user_id', $user_id)->get()
            )
            ->add(
                'votes.json',
                Vote::with('poll')
                    ->without('poll.votes')
                    ->where('user_id', $user_id)
                    ->get()
            )
            ->add(
                'student_information.json',
                StudentInformation::where('user_id', $user_id)->get()
            )
            ->add(
                'created_pages.json',
                Page::where('creator_id', $user_id)->get()
            )
            ->add(
                'group_members.json',
                $this->groups()->get()
            );
    }

    public function personalDataExportName(): string
    {
        $userName = Str::slug($this->name);
        return "personal-data-{$userName}.zip";
    }
}
