<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\Organisation;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class APIEventController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api')->except('get', 'show');
    }

    public function get() {
        return Event::with(['organisation', 'entry'])->get();
    }

    public function show($id) {

        $event = Event::with(['organisation', 'entry'])->findOrFail($id);

        return $event;

    }

    public function store(Request $request) {

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

        $id = $request->get('organisation_id');

        if ($id != null) {

            $organisation = Organisation::find($id);

            if ($request->user()->isOrganisationAdmin($organisation)) {

                $event = Event::create($request->all());

                $event->save();

                return response()->json($event, 201);

            } else {

                return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);

            }

        } else {

            $event = Event::create($request->all());

            $event->save();

            return response()->json($event, 201);

        }


    }

    public function update(Request $request, Event $event) {



    }

    public function delete(Request $request, Event $event) {

        if ($event->organisation() != null) {

            if (!$request->user()->isOrganisationAdmin($event->organisation()->id)) {

                return response()->json(['error' => 'Not authorized. You need to be admin of this organisation.'], 403);

            }

        }

        try {
            $organisation->delete();
        } catch (Exception $e) {}

        return response()->json(null, 204);

    }

    /* Deprecated */

    public function getEvents() {

        return Event::all();

    }

}