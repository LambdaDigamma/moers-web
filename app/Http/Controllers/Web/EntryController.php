<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\EntryRepositoryInterface;
use Inertia\Inertia;

class EntryController extends Controller
{

    private $entryRepository;

    public function __construct(EntryRepositoryInterface $entryRepository)
    {
        $this->entryRepository = $entryRepository;
    }

    public function index()
    {
        return Inertia::render('Entry/Index', [
            'entries' => $this->entryRepository->all()
        ]);
    }

}
