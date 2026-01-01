<?php

namespace Modules\Management\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Inertia\ResponseFactory;
use Modules\Management\Data\CreateOrganisationProps;
use Modules\Management\Data\EditOrganisationProps;
use Modules\Management\Data\ShowOrganisationProps;
use Modules\Management\Data\StoreOrganisationRequest;
use Modules\Management\Models\Organisation;
use Spatie\LaravelData\PaginatedDataCollection;

class OrganisationController extends Controller
{
    public function index()
    {
        $organisations = Organisation::query()->paginate();

        $data = \Modules\Management\Data\Organisation::collect($organisations, PaginatedDataCollection::class);

        return inertia('organisations/index', [
            'organisations' => $data,
        ]);
    }

    public function create(): Response|ResponseFactory
    {
        $props = new CreateOrganisationProps(
            host: parse_url(config('app.url'), PHP_URL_HOST)
        );

        return inertia('organisations/create-organisation', $props);
    }

    public function store(StoreOrganisationRequest $request)
    {
        $organisation = Organisation::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => '',
        ]);

        return redirect()->route('organisations.edit', $organisation);
    }

    public function show(Organisation $organisation)
    {
        $props = new ShowOrganisationProps(
            organisation: \Modules\Management\Data\Organisation::from($organisation)
        );

        return inertia('organisations/show-organisation', $props);
    }

    public function edit(Organisation $organisation)
    {
        $props = new EditOrganisationProps(
            organisation: \Modules\Management\Data\Organisation::from($organisation)
        );

        return inertia('organisations/edit-organisation', $props);
    }
}
