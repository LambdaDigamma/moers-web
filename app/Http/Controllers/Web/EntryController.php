<?php

namespace App\Http\Controllers\Web;

use App\Entry;
use App\Http\Controllers\Controller;
use App\Repositories\EntryRepositoryInterface;
use Inertia\Inertia;

class EntryController extends Controller
{

    private EntryRepositoryInterface $entryRepository;

    public function __construct(EntryRepositoryInterface $entryRepository)
    {
        $this->entryRepository = $entryRepository;
    }

    public function index(Entry $selectedEntry = null)
    {
        return Inertia::render('Entry/Index', [
            'entries' => $this->entryRepository->all(),
            'selectedEntry' => function () use ($selectedEntry) {
                return $selectedEntry;
            }
        ]);
    }

}
