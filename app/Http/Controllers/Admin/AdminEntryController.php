<?php

namespace App\Http\Controllers\Admin;

use anlutro\LaravelSettings\SettingStore;
use App\AdvEvent;
use App\Entry;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEvent;
use App\Http\Requests\UpdateEventPage;
use App\Http\Requests\UpdatePage;
use App\Http\Requests\UpdateStream;
use App\Organisation;
use App\Page;
use App\Repositories\PageRepository;
use App\Repositories\PageRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Redirect;
use Request;

class AdminEntryController extends Controller
{

    public function __construct() {
        $this->middleware('can:access-admin');
        $this->middleware('remember')->only('index');
    }

    public function index()
    {
        return Inertia::render('Admin/Entries/Index', [
            'filters' => Request::all('search'),
            'entries' => Entry::with('organisations')
                ->orderByDesc('name')
                ->filter(Request::only('search'))
                ->paginate()
        ]);
    }

}
