<?php

namespace App\Http\Controllers\Admin;

use App\AdvEvent;
use App\Dataset;
use App\Entry;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEvent;
use App\Http\Requests\UpdateEventPage;
use App\Http\Requests\UpdatePage;
use App\Organisation;
use App\Page;
use App\Repositories\DatasetRepository;
use App\Repositories\PageRepository;
use App\Repositories\PageRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Redirect;
use Request;

class AdminDatasetController extends Controller
{

    private DatasetRepository $datasetRepository;

    public function __construct(DatasetRepository $datasetRepository) {
        $this->middleware('can:access-admin');
        $this->middleware('remember')->only('index');
        $this->datasetRepository = $datasetRepository;
    }

    public function index()
    {
        return Inertia::render('Admin/Datasets/Index', [
            'filters' => Request::all('search'),
            'datasets' => Dataset::withCount('resources')
                ->orderByDesc('name')
//                ->filter(Request::only('search'))
                ->paginate()
        ]);
    }

    public function edit(Dataset $dataset)
    {
        return Inertia::render('Admin/Datasets/Edit', [
            'dataset' => $dataset->load('resources')
        ]);
    }

}
