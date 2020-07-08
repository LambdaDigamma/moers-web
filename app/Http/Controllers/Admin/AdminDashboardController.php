<?php

namespace App\Http\Controllers\Admin;

use App\AdvEvent;
use App\Entry;
use App\Http\Controllers\Controller;
use App\Organisation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
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
