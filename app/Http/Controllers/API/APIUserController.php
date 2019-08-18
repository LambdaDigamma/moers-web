<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
     * @return User
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

        return $user->load('groups');
    }

    /**
     * Detaches the given User from the provided Group.
     * Returns the User with its groups.
     *
     * @param int $userID
     * @param Request $request
     * @return User
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

        return $user->load('groups');
    }

}
