<?php

namespace Modules\News\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\News\Http\Resources\PostCollection;
use Modules\News\Models\Feed;

class FeedPostsController extends Controller
{
    public function index($id): PostCollection
    {
        return new PostCollection(
            Feed::findOrFail($id)
                ->posts()
                ->with(['media'])
                ->chronological()
                ->jsonPaginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id): void
    {
        // return new EventResource(Event::with('page', 'place')->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     */
    public function update(Request $request, $id): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id): void
    {
        //
    }
}
