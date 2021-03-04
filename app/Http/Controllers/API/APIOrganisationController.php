<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use App\Models\Event;
use App\Models\Organisation;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class APIOrganisationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('get', 'show', 'getEvents', 'getEntry', 'store', 'update');
//        $this->middleware('permission:create-organisation')->only('store');
//        $this->middleware('permission:edit-organisation')->only('update', 'storeEvent',
//                                                                                  'deleteEvent', 'associateEntry',
//                                                                                  'detachEntry');
//        $this->middleware('permission:delete-organisation')->only('delete');
    }

    /* Basic */

    public function get()
    {
        return Organisation::with(['users:id,first_name,created_at,updated_at', 'entry'])->get();
    }

    public function show($id)
    {
        $organisation = Organisation::with(['users:id,first_name,created_at,updated_at', 'entry', 'events'])->findOrFail($id);

        return $organisation;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:organisations|max:255',
            'description' => 'required|max:500',
            'entry_id' => 'sometimes|nullable|integer|exists:entries,id'
        ]);

        $organisation = Organisation::create($request->all());

        $request->user()->join($organisation->id);
        $request->user()->makeAdmin($organisation->id);

        $organisation = Organisation::with(['users:id,first_name,created_at,updated_at', 'entry'])->findOrFail($organisation->id);

        return response()->json($organisation, 201);
    }

    public function update(Request $request, Organisation $organisation)
    {
        $request->validate([
            'name' => 'required|unique:organisations|max:255',
            'description' => 'required|max:500',
            'entry_id' => 'sometimes|nullable|integer|exists:entries,id'
        ]);

//        if ($request->user()->isOrganisationAdmin($organisation)) {

        $organisation->update($request->all());

        return response()->json($organisation, 200);

//        } else {
//
//            return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);
//
//        }
    }

    public function delete(Request $request, Organisation $organisation)
    {
        if ($request->user()->isOrganisationAdmin($organisation->id)) {
            try {
                $organisation->delete();
            } catch (Exception $e) {
            }

            return response()->json(null, 204);
        } else {
            return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);
        }
    }

    /* User */

    public function getUsers(Request $request, Organisation $organisation)
    {
        if ($request->user()->isMember($organisation->id)) {
            $users = $organisation->users()->select(['id', 'first_name', 'created_at', 'updated_at'])->get();

            return response()->json($users, 200);
        } else {
            return response()->json(['error' => 'Not authorized. You need to be a member of this organisation.'], 403);
        }
    }

    public function join(Request $request, Organisation $organisation)
    {
        $user = $request->user();

        if ($user->join($organisation->id)) {
            $organisation = Organisation::with(['users:id,first_name,created_at,updated_at', 'entry'])->findOrFail($organisation->id);

            return response()->json($organisation, 200);
        } else {
            return response()->json(['error' => 'You are already member of this organisation.'], 403);
        }
    }

    public function leave(Request $request, Organisation $organisation)
    {
        $user = $request->user();

        $organisation->users()->detach($user->id);

        $organisation = Organisation::with(['users:id,first_name,created_at,updated_at', 'entry'])->findOrFail($organisation->id);

        return response()->json($organisation, 200);
    }

    public function addUser(Request $request, Organisation $organisation)
    {
        if ($request->user()->isOrganisationAdmin($organisation)) {
            $request->validate([
                'user_id' => 'required|integer|exists:users,id'
            ]);

            $userID = $request->input('user_id');

            $organisation->users()->attach($userID);

            $organisation = Organisation::with(['users:id,first_name,created_at,updated_at', 'entry'])->findOrFail($organisation->id);

            return response()->json($organisation, 200);
        } else {
            return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);
        }
    }

    public function removeUser(Request $request, Organisation $organisation)
    {
        if ($request->user()->isOrganisationAdmin($organisation)) {
            $request->validate([
                'user_id' => 'required|integer|exists:users,id'
            ]);

            $userID = $request->input('user_id');

            $organisation->users()->detach($userID);

            $organisation = Organisation::with(['users:id,first_name,created_at,updated_at', 'entry'])->findOrFail($organisation->id);

            return response()->json($organisation, 200);
        } else {
            return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);
        }
    }

    public function makeAdmin(Request $request, Organisation $organisation)
    {
        if ($request->user()->isOrganisationAdmin($organisation)) {
            $request->validate([
                'user_id' => 'required|integer|exists:users,id'
            ]);

            $user = User::find($request->input('user_id'));

            $pivot = $user->makeAdmin();

            return response()->json($pivot, 201);
        } else {
            return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);
        }
    }

    public function makeMember(Request $request, Organisation $organisation)
    {
        if ($request->user()->isOrganisationAdmin($organisation)) {
            $request->validate([
                'user_id' => 'required|integer|exists:users,id'
            ]);

            $user = User::find($request->input('user_id'));

            $pivot = $user->makeMember();

            return response()->json($pivot, 201);
        } else {
            return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);
        }
    }

    /* Events */

    public function getEvents(Organisation $organisation)
    {
        $events = $organisation->events()->get();

        return response()->json($events, 200);
    }

    public function storeEvent(Request $request, Organisation $organisation)
    {
        $request->validate([
            'name' => 'required|max:255',
            'date' => 'required|date|date_format:d.m.Y|after:yesterday',
            'time_start' => [
                'required',
                'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/i'
            ],
            'time_end' => [
                'sometimes',
                'nullable',
                'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/i'
            ],
            'description' => 'sometimes|nullable|string',
            'url' => 'sometimes|nullable|url',
            'category' => 'sometimes|nullable|string|max:255',
            'organisation_id' => 'sometimes|nullable|integer|exists:organisations,id',
            'entry_id' => 'sometimes|nullable|integer|exists:entries,id',
            'extras' => 'sometimes|nullable|json'
        ]);

        if ($request->user()->isOrganisationAdmin($organisation)) {
            $event = Event::create($request->all());

            $event->organisation_id = $organisation->id;

            $event->save();

            return response()->json($event, 201);
        } else {
            return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);
        }
    }

    public function deleteEvent(Request $request, $oID, $eID)
    {
        $organisation = Organisation::findOrFail($oID);

        if ($request->user()->isOrganisationAdmin($organisation)) {
            $event = Event::findOrFail($eID);

            try {
                $event->delete();
            } catch (Exception $e) {
            }

            return response()->json(null, 204);
        } else {
            return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);
        }
    }

    /* Entry */

    public function getEntry(Organisation $organisation)
    {
        $entry = $organisation->entry()->first();

        if ($entry != null) {
            return response()->json($entry, 200);
        } else {
            return response()->json(['error' => 'No entry exists for this organisation.'], 404);
        }
    }

    public function associateEntry(Request $request, Organisation $organisation)
    {
        $request->validate([
            'entry_id' => 'required|integer|exists:entries,id',
        ]);

        if ($request->user()->isOrganisationAdmin($organisation)) {
            $id = $request->input('entry_id');

            if ($id != null && Entry::find($id) != null) {
                $organisation->entry_id = $id;
                $organisation->save();

                $organisation = Organisation::with(['users:id,first_name,created_at,updated_at', 'entry'])->findOrFail($organisation->id);

                return response()->json($organisation, 201);
            } else {
                return response()->json(['error' => 'Entry not found. Check the payload and provide a valid entry_id.'], 403);
            }
        } else {
            return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);
        }
    }

    public function detachEntry(Request $request, Organisation $organisation)
    {
        if ($request->user()->isOrganisationAdmin($organisation)) {
            $organisation->entry_id = null;
            $organisation->save();

            return response()->json(null, 204);
        } else {
            return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);
        }
    }
}
