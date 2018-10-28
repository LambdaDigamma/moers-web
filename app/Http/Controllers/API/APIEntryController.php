<?php

namespace App\Http\Controllers\API;

use App\Entry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class APIEntryController extends Controller
{

    public function get() {

        $entries = Entry::all();

        foreach ($entries as $key => $entry) {

            $tags = explode(', ', $entry->tags);

            $entry->tags = $tags;
            $entry->is_validated = $entry->is_validated == 1 ? true : false;

        }

        return $entries;

    }

    public function store(Request $request) {

        $inputs = $request->all();

        $isAllowed = true;

        if (!$isAllowed) {
            return response()->json(["success" => false], 401);
        }

        if ($inputs['secret'] == "tzVQl34i6SrYSzAGSkBh") {

            $entry = new Entry();

            $entry->name = $inputs['name'];
            $entry->street = $inputs['street'];
            $entry->tags = $inputs['tags'];
            $entry->house_number = $inputs['house_number'];
            $entry->postcode = $inputs['postcode'];
            $entry->place = $inputs['place'];
            $entry->lat = $inputs['lat'];
            $entry->lng = $inputs['lng'];
            $entry->url = $inputs['url'];
            $entry->phone = $inputs['phone'];
            $entry->monday = $inputs['monday'];
            $entry->tuesday = $inputs['tuesday'];
            $entry->wednesday = $inputs['wednesday'];
            $entry->thursday = $inputs['thursday'];
            $entry->friday = $inputs['friday'];
            $entry->saturday = $inputs['saturday'];
            $entry->sunday = $inputs['sunday'];
            $entry->other = $inputs['other'];


            $entry->save();

            return response()->json($entry, 201);

        } else {
            return response()->json(["success" => false], 401);
        }

    }

}
