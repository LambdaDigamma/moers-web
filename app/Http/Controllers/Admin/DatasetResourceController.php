<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateGeneralResource;
use App\Jobs\UpdateAndRevalidateResource;
use App\Models\Dataset;
use App\Models\DatasetResource;
use App\Repositories\DatasetRepository;
use Inertia\Inertia;
use Log;
use Redirect;

class DatasetResourceController extends Controller
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

    public function loadResource(Dataset $dataset, DatasetResource $resource, string $lang = "de")
    {
        UpdateAndRevalidateResource::dispatch($resource);
        Log::debug('Test');
        return Redirect::route('admin.datasets.resources.edit', [$dataset->id, $resource->id, $lang])
            ->with('success', 'Die Resource wird bei nächster Gelegenheit akutalisiert.');
    }


}
