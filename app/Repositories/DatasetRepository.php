<?php


namespace App\Repositories;

use App\Entry;
use App\Page;
use App\PageBlock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DatasetRepository implements DatasetRepositoryInterface
{
    public function all()
    {
        return collect([]);
    }
}
