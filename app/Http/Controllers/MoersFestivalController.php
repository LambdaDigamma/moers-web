<?php

namespace App\Http\Controllers;

use App\AdvEvent;
use App\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MoersFestivalController extends Controller
{
    public $mfOrganisationID = 1;

    public function getEvents()
    {
        $organisation = Organisation::where('name', '=', 'moers festival')->firstOrFail();

        $events = $organisation->publishedEvents()->with('entry', 'organisation', 'page', 'page.blocks')->get();

        return response()->json($events, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|max:255',
            'description' => 'sometimes|nullable|string',
            'start_date' => 'sometimes|nullable|date_format:Y-m-d H:i:s',
            'end_date' => 'sometimes|nullable|date_format:Y-m-d H:i:s',
            'url' => 'sometimes|nullable|url',
            'image_path' => 'sometimes|nullable|url',
            'entry_id' => 'sometimes|nullable|integer|exists:entries,id',
            'organisation_id' => 'sometimes|nullable|integer|exists:organisations,id',
            'extras.needsFestivalTicket' => 'sometimes|nullable|boolean',
            'extras.isFree' => 'sometimes|nullable|boolean',
            'extras.visitWithExtraTicket' => 'sometimes|nullable|boolean',
            'extras.color' => 'sometimes|nullable|string',
            'extras.descriptionEN' => 'sometimes|nullable|string',
            'extras.iconURL' => 'sometimes|nullable|url'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        } else {
            $organisation = Organisation::where('name', '=', 'moers festival')->firstOrFail();

            $event = AdvEvent::create($request->json()->all());
            $event->organisation_id = $organisation->id;
            $event->save();

            return response()->json($event, 201);
        }
    }

    public function getStream()
    {
        return [
            'stream_url' => null
        ];
    }
}
