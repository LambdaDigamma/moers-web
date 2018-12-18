<?php

namespace App\Http\Controllers\API;

use App\Entry;
use App\Event;
use App\Organisation;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class APIOrganisationController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api')->except('get', 'show', 'getEvents', 'getEntry');
//        $this->middleware('permission:create-organisation')->only('store');
//        $this->middleware('permission:edit-organisation')->only('update', 'storeEvent',
//                                                                                  'deleteEvent', 'associateEntry',
//                                                                                  'detachEntry');
//        $this->middleware('permission:delete-organisation')->only('delete');
    }

    /* Basic */

    public function get() {
        return Organisation::with(['users:id,name,created_at,updated_at', 'entry'])->get();
    }

    public function show($id) {

        $organisation = Organisation::with(['users:id,name,created_at,updated_at', 'entry'])->findOrFail($id);

        return $organisation;
    }

    public function store(Request $request) {

        $organisation = Organisation::create($request->all());

        $id = $organisation->id;

        $this->join($request, $id);

        return response()->json($organisation, 201);

    }

    public function update(Request $request, Organisation $organisation) {

        if ($request->user()->organisationRole($organisation->id) == 'admin') {

            $organisation->update($request->all());

            return response()->json($organisation, 200);

        } else {

            return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);

        }

    }

    public function delete(Request $request, Organisation $organisation) {

        if ($request->user()->isOrganisationAdmin($organisation->id)) {

            try {
                $organisation->delete();
            } catch (Exception $e) {}

            return response()->json(null, 204);

        } else {

            return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);

        }

    }

    /* User */

    public function getUsers(Request $request, Organisation $organisation) {

        if ($request->user()->isMember($organisation)) {

            $users = $organisation->users()->select(['id', 'name', 'created_at', 'updated_at'])->get();

            return response()->json($users, 200);

        } else {

            return response()->json(['error' => 'Not authorized. You need to be a member of this organisation.'], 403);

        }

    }

    public function join(Request $request, Organisation $organisation) {

        $user = $request->user();

        if (!$user->isMember($organisation)) {

            $organisation->users()->attach($user->id);

            $organisation = Organisation::with(['users:id,name,created_at,updated_at', 'entry'])->findOrFail($organisation->id);

            return response()->json($organisation, 200);

        } else {

            return response()->json(['error' => 'You are already member of this organisation.'], 403);

        }

    }

    public function leave(Request $request, Organisation $organisation) {

        $userID = $request->user()->id;

        $organisation->users()->detach($userID);

        $organisation = Organisation::with(['users:id,name,created_at,updated_at', 'entry'])->findOrFail($organisation->id);

        return response()->json($organisation, 200);

    }

    public function makeAdmin(Request $request, Organisation $organisation) {

        $user = User::find($request->input('userID'));

        if ($user != null) {

            if ($request->user()->isOrganisationAdmin($organisation) &&
                $user->id != $request->user()->id) {

                $pivot = $user->organisations()->findOrFail($organisation->id)->pivot;

                $pivot->role = 'admin';
                $pivot->save();

                return response()->json($pivot, 201);

            } else {

                return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);

            }

        } else {

            return response()->json(['error' => 'This user does not exist. Check your payload.'], 403);

        }

    }

    public function makeMember(Request $request, Organisation $organisation) {

        $user = User::find($request->input('userID'));

        if ($user != null) {

            if ($request->user()->isOrganisationAdmin($organisation) &&
                $user->id != $request->user()->id) {

                $pivot = $user->organisations()->findOrFail($organisation->id)->pivot;

                $pivot->role = 'member';
                $pivot->save();

                return response()->json($pivot, 201);

            } else {

                return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);

            }

        } else {

            return response()->json(['error' => 'This user does not exist. Check your payload.'], 403);

        }

    }

    /* Events */

    public function getEvents(Organisation $organisation) {

        $events = $organisation->events()->get();

        return response()->json($events, 200);

    }

    public function storeEvent(Request $request, Organisation $organisation) {

        if ($request->user()->isOrganisationAdmin($organisation)) {

            $event = Event::create($request->all());

            $event->organisation_id = $organisation->id;

            $event->save();

            return response()->json($event, 201);

        } else {

            return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);

        }

    }

    public function deleteEvent(Request $request, $oID, $eID) {

        $organisation = Organisation::findOrFail($oID);

        if ($request->user()->isOrganisationAdmin($organisation)) {

            $event = Event::findOrFail($eID);

            try {
                $event->delete();
            } catch (Exception $e) {}

            return response()->json(null, 204);

        } else {

            return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);

        }

    }

    /* Entry */

    public function getEntry(Organisation $organisation) {

        $entry = $organisation->entry()->first();

        if ($entry != null) {

            return response()->json($entry, 200);

        } else {

            return response()->json(['error' => 'No entry exists for this organisation.'], 404);

        }

    }

    public function associateEntry(Request $request, Organisation $organisation) {

        if ($request->user()->isOrganisationAdmin($organisation)) {

            $id = $request->input('entryID');

            if ($id != null && Entry::find($id) != null) {

                $organisation->entry_id = $id;
                $organisation->save();

                $organisation = Organisation::with(['users:id,name,created_at,updated_at', 'entry'])->findOrFail($organisation->id);

                return response()->json($organisation, 201);

            } else {

                return response()->json(['error' => 'Entry not found. Check the payload and provide a valid entryID.'], 403);

            }

        } else {

            return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);

        }

    }

    public function detachEntry(Request $request, Organisation $organisation) {

        if ($request->user()->isOrganisationAdmin($organisation)) {

            $organisation->entry_id = null;
            $organisation->save();

            return response()->json(null, 204);

        } else {

            return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);

        }

    }

}
