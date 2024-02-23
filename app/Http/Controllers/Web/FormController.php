<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentInformation;
use App\Models\StudentInformation;
use Auth;
use Inertia\Inertia;
use Redirect;
use Request;

class FormController extends Controller
{

    public function student()
    {
        return Inertia::render('Forms/Student', [
            'existingInformation' => StudentInformation::where('user_id', '=', auth()->id())->first()
        ]);
    }

    public function saveStudentForm(StoreStudentInformation $request)
    {

        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->id;

        $information = StudentInformation::updateOrCreate(['user_id' => Auth::user()->id], $validated);

        if (Request::hasFile('photo_old')) {
            $information->photo_old_path = Request::file('photo_old') ? Request::file('photo_old')->store('photos_old') : null;
        }
        if (Request::hasFile('photo_new')) {
            $information->photo_new_path = Request::file('photo_new') ? Request::file('photo_new')->store('photos_new') : null;
        }

        $information->save();

        return Redirect::route('forms.student')
            ->with('success', 'Erfolgreich gespeichert.');

    }

}
