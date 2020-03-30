<?php


namespace App\Http\Controllers\Web;


use App\AdvEvent;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class EventController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {

        return Inertia::render('Event/Index', [
            'todayEvents' => AdvEvent::published()->active()->get()
        ]);

    }

}