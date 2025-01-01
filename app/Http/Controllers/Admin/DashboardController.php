<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdvEvent;
use App\Models\Entry;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Organisation\Models\Organisation;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:access-admin');
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('Admin/Dashboard', [
            'numberOfEntries' => Entry::all()->count(),
            'numberOfOrganisations' => Organisation::all()->count(),
            'numberOfEvents' => AdvEvent::all()->count()
        ]);
    }
}
