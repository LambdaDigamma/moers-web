<?php


namespace App\Repositories;

use App\Entry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EntryRepository implements EntryRepositoryInterface
{

    /**
     * Returns all validated entries.
     * @return Builder[]|Collection
     */
    public function all()
    {
        return Entry::where('is_validated', '=', 1)
            ->get();
    }

    public function allTags()
    {
        return $this
            ->all()
            ->map(function ($entry) {
                return $entry->tags;
            })
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    /**
     * Gets entry by it's ID
     *
     * @param $entry_id
     * @return Entry|Collection|Model|null
     */
    public function get($entry_id)
    {
        return Entry::find($entry_id);
    }

    /**
     * Stores a new entry.
     * @param array $data
     * @return Entry|Model
     */
    public function store(array $data): Entry
    {
        $entry = Entry::make($data);
        $entry->is_validated = true;
        $entry->save();

        return $entry;
    }

    /**
     * Updates an entry with the given data.
     * @param $entry_id
     * @param array $data
     * @return Entry
     */
    public function update($entry_id, array $data): Entry
    {
        Entry::find($entry_id)->update($data);
        return Entry::find($entry_id);
    }

    /**
     * Deletes an entry.
     * @param $entry_id
     */
    public function delete($entry_id)
    {
        Entry::destroy($entry_id);
    }

    /**
     * Restores the entry by the given ID.
     * @param $entry_id
     */
    public function restore($entry_id)
    {
        Entry::find($entry_id)->restore();
    }
}
