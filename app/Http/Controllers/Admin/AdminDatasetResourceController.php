<?php

namespace App\Http\Controllers\Admin;

use App\AdvEvent;
use App\Dataset;
use App\DatasetResource;
use App\Entry;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEvent;
use App\Http\Requests\UpdateEventPage;
use App\Http\Requests\UpdateGeneralResource;
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

class AdminDatasetResourceController extends Controller
{
    private DatasetRepository $datasetRepository;

    public function __construct(DatasetRepository $datasetRepository)
    {
        $this->middleware('can:access-admin');
        $this->middleware('remember')->only('index');
        $this->datasetRepository = $datasetRepository;
    }

    public function create(Dataset $dataset)
    {
        return Inertia::render('Admin/Datasets/Resources/Create', [
            'dataset' => $dataset->load('resources')
        ]);
    }

    public function storeResource(Dataset $dataset, UpdateGeneralResource $request)
    {
        $validated = $request->validated();

        $dataset->resources()->save(DatasetResource::make($validated));

        return Redirect::route('admin.datasets.edit', [$dataset->id]);
    }

    public function edit(Dataset $dataset, DatasetResource $resource)
    {
        return Inertia::render('Admin/Datasets/Resources/Edit', [
            'dataset' => $dataset,
            'resource' => $resource
        ]);
    }

    public function update(Dataset $dataset, DatasetResource $resource, UpdateGeneralResource $request, string $lang = "de")
    {
        $validated = $request->validated();

        app()->setLocale($lang);

        if ($lang != "de") {
            $resource->setTranslation('name', $lang, $request->get('name'));
            $resource->save();
        } else {
            $resource->update($validated);
        }

        return Redirect::route('admin.datasets.resources.edit', [$dataset->id, $resource->id, $lang])
            ->with('success', 'Daten gespeichert.');
    }
}
