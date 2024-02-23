<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LegalController extends Controller
{

    public function privacy()
    {
        SEOTools::setTitle('Datenschutz');

        return view('legal.privacy');
    }

    public function tac()
    {
        SEOTools::setTitle('AGBs');

        return view('legal.tac');
    }

    public function imprint()
    {
        SEOTools::setTitle('Impressum');

        return view('legal.imprint');
    }

}
