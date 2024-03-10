<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Modules\Rubbish\Models\RubbishStreet;

class RubbishController extends Controller
{
    public function index()
    {
        SEOTools::setTitle("Abfallkalender");
        SEOTools::setDescription("Suche eine Straße und finde alle Termine, an denen die Müllabfuhr kommt.");
        SEOMeta::addKeyword(['müll', 'enni', 'müllabfuhr', 'moers', 'straße']);

        return view('rubbish.index');
    }

    public function show(RubbishStreet $street)
    {
        SEOTools::setTitle($street->name);
        SEOTools::setDescription("Eine Übersicht aller Abfuhrtermine für: $street->name");

        return view('rubbish.show', [
            'street' => $street
        ]);
    }
}
