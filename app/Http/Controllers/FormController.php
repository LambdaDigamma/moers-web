<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentInformation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

class FormController extends Controller
{

    public function student()
    {
        return Inertia::render('Forms/Student', [

        ]);
    }

    public function saveStudentForm(StoreStudentInformation $request)
    {

        return Redirect::route('dashboard')
            ->with('success', 'Erfolgreich abgesendet.');

    }

}
