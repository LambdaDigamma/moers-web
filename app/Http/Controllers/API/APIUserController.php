<?php

namespace App\Http\Controllers\API;

use App\Group;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Poll;
use Bouncer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class APIUserController extends Controller
{

    /**
     * Returns all Users.
     * @return User[]|Collection
     */
    public function all()
    {
        return User::all();
    }

    /**
     * Returns the User for the given $id with its associated Groups.
     *
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return User::where('id', $id)->with('groups')->first();
    }

    /**
     * Updates Name, Email and Description of the given User using the provided Request.
     *
     * @param Request $request
     * @param User $user
     * @return User
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|min:5|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $data = $request->json()->all();

        $user->update($data);

        return $user->load('groups');
    }

    /**
     * Associates the given User with the provided Group.
     * Also checks that the relation did not exist before.
     * Returns the User with its groups.
     *
     * @param int $userID
     * @param Request $request
     * @return array
     */
    public function joinGroup($userID, Request $request)
    {
        $user = User::findOrFail($userID);

        $validatedData = $request->validate([
            'group_id' => 'required|integer|exists:groups,id'
        ]);

        $groupID = $validatedData['group_id'];

        if (!$user->groups->contains($groupID)) {
            $user->groups()->attach($groupID);
        }

        $group = Group::with('users')->findOrFail($groupID);

        return [
            'group' => $group,
            'user' => $user->load('groups')
        ];
    }

    /**
     * Detaches the given User from the provided Group.
     * Returns the User with its groups.
     *
     * @param int $userID
     * @param Request $request
     * @return array
     */
    public function leaveGroup($userID, Request $request)
    {
        $user = User::findOrFail($userID);

        $validatedData = $request->validate([
            'group_id' => 'required|integer|exists:groups,id'
        ]);

        $groupID = $validatedData['group_id'];

        if ($user->groups->contains($groupID)) {
            $user->groups()->detach($groupID);
        }

        $group = Group::with('users')->findOrFail($groupID);

        return [
            'group' => $group,
            'user' => $user->load('groups')
        ];
    }

    /**
     * Allow the provided User to create Polls.
     *
     * @param $userID
     * @param Request $request
     *
     * @return mixed
     */
    public function allowCreatePoll($userID)
    {
        $user = User::findOrFail($userID);
        Bouncer::allow($user)->to('create-poll', Poll::class);
        return $user;
    }

    /**
     * Disallow the provided User to create Polls.
     *
     * @param $userID
     *
     * @return mixed
     */
    public function disallowCreatePoll($userID)
    {
        $user = User::findOrFail($userID);
        Bouncer::disallow($user)->to('create-poll', Poll::class);
        return $user;
    }
}
