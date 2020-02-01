<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\EntryRepositoryInterface;

class EntryController extends Controller
{

    private $entryRepository;

    public function __construct(EntryRepositoryInterface $entryRepository)
    {
        $this->entryRepository = $entryRepository;
    }

}
