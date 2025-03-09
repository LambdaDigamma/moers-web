<?php

namespace Modules\Management\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Inertia\ResponseFactory;
use Modules\Management\Data\CreateOrganisationProps;
use Modules\Management\Data\StoreOrganisationRequest;

class OrganisationController extends Controller
{
    public function create(): Response|ResponseFactory
    {
        $props = new CreateOrganisationProps(
            host: parse_url(config('app.url'), PHP_URL_HOST)
        );

        return inertia('organisations/create-organisation', $props);
    }

    public function store(StoreOrganisationRequest $request)
    {
        dd($request->all());
    }
}
