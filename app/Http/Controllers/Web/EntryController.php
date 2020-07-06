<?php

namespace App\Http\Controllers\Web;

use App\Entry;
use App\Http\Controllers\Controller;
use App\Repositories\EntryRepositoryInterface;
use Inertia\Inertia;
use Request;

class EntryController extends Controller
{

    private EntryRepositoryInterface $entryRepository;

    public function __construct(EntryRepositoryInterface $entryRepository)
    {
        $this->middleware('remember')->only('index');
        $this->entryRepository = $entryRepository;
    }

    public function index(Entry $selectedEntry = null)
    {
        return Inertia::render('Entry/Index', [
            'entries' => Entry::query()
                ->validated()
                ->filter(Request::only('search'))
                ->get(),
            'tags' => $this->entryRepository->allTags(),
            'selectedEntry' => function () use ($selectedEntry) {
                return $selectedEntry;
            },
            'filters' => Request::all('search'),
        ]);
    }

}
