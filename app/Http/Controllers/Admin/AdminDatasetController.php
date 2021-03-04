<?php

namespace App\Http\Controllers\Admin;

use App\Dataset;
use App\Http\Controllers\Controller;
use App\Repositories\DatasetRepository;
use Inertia\Inertia;
use Request;

class AdminDatasetController extends Controller
{
    private DatasetRepository $datasetRepository;

    public function __construct(DatasetRepository $datasetRepository)
    {
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
