<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentInformation;
use App\StudentInformation;
use Auth;
use Inertia\Inertia;
use Redirect;
use Request;

class FormController extends Controller
{

    public function student()
    {
        return Inertia::render('Forms/Student', [

        ]);
    }

    public function saveStudentForm(StoreStudentInformation $request)
    {

        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->id;

//        dd($validated);

        $information = StudentInformation::updateOrCreate(['user_id' => Auth::user()->id], $validated);

        $information->photo_old_path = Request::file('photo_old') ? Request::file('photo_old')->store('photos_old') : null;
        $information->photo_new_path = Request::file('photo_new') ? Request::file('photo_new')->store('photos_new') : null;
        $information->save();

        return Redirect::route('dashboard')
            ->with('success', 'Erfolgreich abgesendet.');

    }

}
