<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEntry;
use App\Http\Requests\UpdateEntry;
use App\Models\Entry;
use App\Repositories\EntryRepositoryInterface;
use Illuminate\Http\Request;

class APIEntryController extends Controller
{
    private $entryRepository;

    public function __construct(EntryRepositoryInterface $entryRepository)
    {
        $this->entryRepository = $entryRepository;
    }

    public function get()
    {
        return $this->entryRepository->all();
    }

    public function store(StoreEntry $request)
    {
        $data = $request->validated();

        $isAllowed = true;

        if (!$isAllowed) {
            return response()->json(['error' => 'Not allowed. Inserting entries is temporarily not allowed.'], 401);
        }

        if ($request->get('secret') == 'tzVQl34i6SrYSzAGSkBh') {
            $entry = $this->entryRepository->store($data);

            return response()->json($entry, 201);
        } else {
            return response()->json(['error' => 'Not authorized. Client secret is not valid.'], 403);
        }
    }

    public function update(UpdateEntry $request, Entry $entry)
    {
        $data = $request->validated();

        $isAllowed = true;

        if (!$isAllowed) {
            return response()->json(['error' => 'Not allowed. Inserting entries is temporarily not allowed.'], 401);
        }

        $secret = $request->get('secret');

        if ($secret == 'tzVQl34i6SrYSzAGSkBh') {
            $entry = $this->entryRepository->update($entry->id, $data);

            return response()->json($entry, 201);
        } else {
            return response()->json(['error' => 'Not authorized. Client secret is not valid.'], 403);
        }
    }

    public function delete(Request $request, Entry $entry)
    {

//        try {
//            $entry->delete();
//        } catch (Exception $e) {}
//
//        return response()->json(null, 204);
    }

    public function getHistory(Entry $entry)
    {
        return $entry->audits()->select('id', 'event', 'old_values', 'new_values', 'created_at', 'updated_at')->get();
    }
}
