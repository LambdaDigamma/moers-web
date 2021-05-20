<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        return Event::query()
            ->upcoming()
            ->get();
    }

    public function show(Event $event)
    {
        return $event;
    }
}