<?php

namespace App\Http\Controllers\Admin;

use App\Entry;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUpdateEntry;
use App\StudentInformation;
use App\User;
use Inertia\Inertia;
use Redirect;
use Request;

class AdminStudentController extends Controller
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
            'students' => StudentInformation::with('user')
//                ->orderBy('user.last_name')
//                ->orderBy('user.first_name')
//                ->filter(Request::only('search'))
                ->paginate(160),
            'users' => User::query()
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->select(['first_name', 'last_name'])
                ->paginate(160)
                ->makeVisible(['last_name'])
        ]);
    }
}
