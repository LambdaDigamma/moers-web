<?php

namespace App\Http\Controllers;

class LandingPageController extends Controller
{
    public function index()
    {
//        SEOTools::setDescription('Digitale Bürgerinformation auf Basis von offenen Daten. Geschäfte, Parkplätze, 360° Panoramen, Veranstaltungen, aktuelle Kraftstoffpreise, Abfallkalender und vieles mehr!');

        return view('marketing');
    }
}
