<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{

    public function __construct()
    {
        $this->middleware('entrust-gui.admin');
    }

    public function index()
    {
        $activities = DB::table('activities')->paginate('10');

        return view('admin.activities.index', ['activities' => $activities]);
    }

}
