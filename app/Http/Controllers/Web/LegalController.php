<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LegalController extends Controller
{

    public function privacy()
    {
        return Inertia::render('Legal/Privacy');
    }

    public function tac()
    {
        return Inertia::render('Legal/TermsAndConditions');
    }

    public function imprint()
    {
        return Inertia::render('Legal/Imprint');
    }

}
