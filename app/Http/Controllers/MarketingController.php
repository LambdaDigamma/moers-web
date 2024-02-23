<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function app()
    {
        SEOTools::setTitle('App');

        return view('pages.app');
    }
}
