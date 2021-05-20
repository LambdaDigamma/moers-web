<?php

namespace App\Http\Controllers;

use App\Models\RubbishStreet;
use Illuminate\Http\Request;

class RubbishController extends Controller
{

    public function index()
    {
        return view('rubbish.index');
    }

    public function show(RubbishStreet $street)
    {
        return view('rubbish.show', [
            'street' => $street
        ]);
    }

}
