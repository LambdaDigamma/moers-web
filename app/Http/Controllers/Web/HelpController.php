<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfile;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;
use Spatie\PersonalDataExport\Jobs\CreatePersonalDataExportJob;

class HelpController extends Controller
{

    public function index()
    {

        return Inertia::render('Help/Index', [

        ]);
    }

    public function serve()
    {

    }

    public function need()
    {

    }

}
