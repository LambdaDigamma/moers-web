<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class FuelController extends Controller
{
    public function index()
    {
        SEOTools::setTitle('Kraftstoff');

        return view('petrol.index');
    }
}
