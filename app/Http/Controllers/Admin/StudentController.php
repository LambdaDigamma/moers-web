<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentInformation;
use App\Models\User;
use Inertia\Inertia;
use Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:access-admin');
        $this->middleware('remember')->only('index');
    }

    public function index()
    {
        return Inertia::render('Admin/Forms/Students', [
            'filters' => Request::all('search'),
            'users' => User::with('studentInformation')
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->paginate(160)
                ->makeVisible(['last_name']),
            'missing_information' => User::doesntHave('studentInformation')
                ->get()
                ->makeVisible(['last_name'])
        ]);
    }

    public function show(StudentInformation $studentInformation)
    {
//        dd($studentInformation);

//        $studentInformation->load('user');
        return Inertia::render('Admin/Forms/StudentInformation', [
            'studentInformation' => $studentInformation
        ]);
    }

}
