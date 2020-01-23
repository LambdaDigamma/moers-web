<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('Dashboard', [
            'unansweredPolls' => Auth::user()
                ->polls()
                ->unanswered()
                ->take(3)
                ->get(),
            'answeredPolls' => Auth::user()
                ->polls()
                ->answered()
                ->take(3)
                ->get()
        ]);
    }
}
