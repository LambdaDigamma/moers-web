<?php

namespace Modules\Management\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Management\Models\Organisation;

class OrganisationPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Organisation $organisation): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true; // Any authenticated user can create an organisation?
    }

    public function update(User $user, Organisation $organisation): bool
    {
        return $user->belongsToOrganisation($organisation);
    }

    public function delete(User $user, Organisation $organisation): bool
    {
        return $user->belongsToOrganisation($organisation);
    }

    public function createEvents(User $user, Organisation $organisation): bool
    {
        return $user->belongsToOrganisation($organisation);
    }
}
