<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventCollection;
use App\Models\Event;
use Illuminate\Http\Request;
use LambdaDigamma\MMEvents\Resources\Event as EventResource;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return EventCollection
     */
    public function index()
    {
        $events = Event::query()
            // ->with('place')
            ->chronological()
            ->future()
            ->jsonPaginate();

        return new EventCollection($events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::query()
            // ->with(['page'])
            ->findOrFail($id);

        return $event;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
