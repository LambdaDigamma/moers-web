<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;

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
        return Redirect::route('help.index');
//        return Inertia::render('Dashboard', [
//            'title' => 'Übersicht',
//            'unansweredPolls' => Auth::user()
//                ->polls()
//                ->unanswered()
//                ->take(3)
//                ->get(),
//            'answeredPolls' => Auth::user()
//                ->polls()
//                ->answered()
//                ->take(3)
//                ->get()
//        ]);
    }
}
