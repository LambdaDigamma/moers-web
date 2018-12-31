<?php

namespace App\Http\Controllers\API;

use App\Entry;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class APIEntryController extends Controller
{

    public function __construct() {

    }

    /* Basic */

    public function get() {

        $entries = Entry::all();

        foreach ($entries as $key => $entry) {

            $tags = explode(', ', $entry->tags);

            if ($tags != [""]) {
                $entry->tags = $tags;
            } else {
                $entry->tags = array();
            }

            $entry->is_validated = $entry->is_validated == 1 ? true : false;

        }

        return $entries;

    }

    public function store(Request $request) {

        // TODO: Add Lat / Lng Validator
        $request->validate([
            'lat' => [
                'required',
                'numeric'
            ],
            'lng' => [
                'required',
                'numeric'
            ],
            'name' => 'required|max:255',
            'tags' => 'required|max:1000',
            'street' => 'required|max:255',
            'house_number' => 'required|max:255',
            'postcode' => 'required|digits:5',
            'place' => 'required|max:255',
            'url' => 'sometimes|nullable|url',
            'phone' => 'sometimes|nullable|max:255',
            'monday' => 'sometimes|nullable|max:255',
            'tuesday' => 'sometimes|nullable|max:255',
            'wednesday' => 'sometimes|nullable|max:255',
            'thursday' => 'sometimes|nullable|max:255',
            'friday' => 'sometimes|nullable|max:255',
            'saturday' => 'sometimes|nullable|max:255',
            'sunday' => 'sometimes|nullable|max:255',
            'other' => 'sometimes|nullable|max:255',
        ]);

        $isAllowed = true;

        if (!$isAllowed) {
            return response()->json(['error' => 'Not allowed. Inserting entries is temporarily not allowed.'], 401);
        }

        if ($request->get('secret') == 'tzVQl34i6SrYSzAGSkBh') {

            $entry = Entry::create($request->all());

            return response()->json($entry, 201);

        } else {
            return response()->json(['error' => 'Not authorized. Client secret is not valid.'], 403);
        }

    }

    public function update(Request $request, Entry $entry) {

        // TODO: Add Lat / Lng Validator
        $request->validate([
            'lat' => [
                'numeric'
            ],
            'lng' => [
                'numeric'
            ],
            'name' => 'max:255',
            'tags' => 'max:1000',
            'street' => 'max:255',
            'house_number' => 'max:255',
            'postcode' => 'digits:5',
            'place' => 'max:255',
            'url' => 'nullable|url',
            'phone' => 'nullable|max:255',
            'monday' => 'nullable|max:255',
            'tuesday' => 'nullable|max:255',
            'wednesday' => 'nullable|max:255',
            'thursday' => 'nullable|max:255',
            'friday' => 'nullable|max:255',
            'saturday' => 'nullable|max:255',
            'sunday' => 'nullable|max:255',
            'other' => 'nullable|max:255',
        ]);

        $isAllowed = true;

        if (!$isAllowed) {
            return response()->json(['error' => 'Not allowed. Inserting entries is temporarily not allowed.'], 401);
        }

        $data = $request->json()->all();
        $secret = $data['secret'];

        if ($secret == 'tzVQl34i6SrYSzAGSkBh') {

            $entry->update($data);
            $entry->save();

            $entry = Entry::findOrFail($entry->id);

            $tags = explode(', ', $entry->tags);

            if ($tags != [""]) {
                $entry->tags = $tags;
            } else {
                $entry->tags = array();
            }

            $entry->is_validated = $entry->is_validated == 1 ? true : false;

            return response()->json($entry, 201);

        } else {
            return response()->json(['error' => 'Not authorized. Client secret is not valid.'], 403);
        }

    }

    public function delete(Request $request, Entry $entry) {

//        try {
//            $entry->delete();
//        } catch (Exception $e) {}
//
//        return response()->json(null, 204);

    }

    public function getHistory(Entry $entry) {

        return $entry->audits()->select('id', 'event', 'old_values', 'new_values', 'created_at', 'updated_at')->get();

    }

}
