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

}
