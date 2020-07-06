<?php


namespace App\Repositories;

use App\Entry;

interface EntryRepositoryInterface
{
    public function all();

    public function allTags();

    public function get($entry_id);

    public function store(array $data): Entry;

    public function update($entry_id, array $data): Entry;

    public function delete($entry_id);

    public function restore($entry_id);
}
