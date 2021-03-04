<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Auth;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class APIGroupController extends Controller
{

    /**
     * APIGroupController constructor.
     * Adds a middleware.
     */
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    /**
     * Returns a Collection of Groups that the authenticated User is associated with.
     *
     * @return Collection
     */
    public function index()
    {
        return Auth::user()->groups;
    }

    /**
     * Returns a Collection of all existing groups.
     *
     * @return \App\Models\Group[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Group::all();
    }

    /**
     * Returns the requested Group with its Users and their abilities.
     *
     * @param $id
     * @return Group|Group[]|Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function get($id)
    {
        $group = Group::with('users')->findOrFail($id);

        foreach ($group->users as $user) {
            $user->abilities = $user->getAbilities();
        }

        return $group;
    }

    /**
     * Updates Name, Description and Organisation of the given Group using the provided Request.
     *
     * @param Request $request
     * @param Group $group
     * @return Group
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:500',
            'description' => 'required|string',
            'organisation_id' => 'nullable|integer|exists:organisations,id'
        ]);

        $data = $request->json()->all();

        $group->update($data);

        return $group->load('users');
    }

    /**
     * Allow the provided User to create a Poll for this group.
     *
     * @param Request $request
     * @param Group $group
     *
     * @return Group
     */
    public function allowCreatePoll(Request $request, Group $group)
    {
        $user = User::findOrFail($request->get('user_id'));
        Bouncer::allow($user)->to('create-poll-group', $group);
        return $group;
    }

    /**
     * Disallow the provided User to create a Poll for this group.
     *
     * @param Request $request
     * @param Group $group
     *
     * @return Group
     */
    public function disallowCreatePoll(Request $request, Group $group)
    {
        $user = User::findOrFail($request->get('user_id'));
        Bouncer::disallow($user)->to('create-poll-group', $group);
        return $group;
    }

}
