<?php

namespace Modules\News\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\News\Http\Resources\Feed as FeedResource;
use Modules\News\Models\Feed;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(): void
    {
        // return new EventCollection(Event::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return void
     */
    public function store(Request $request): void
    {
        //
    }

    public function show(int $id): FeedResource
    {
        $sizeParameter = config('json-api-paginate.size_parameter');
        $paginationParameter = config('json-api-paginate.pagination_parameter');

        $size = (int) request()->input($paginationParameter.'.'.$sizeParameter, 10);

        return new FeedResource(
            Feed::with([
                'posts' => function ($query) {
                    $query
                        ->with(['media'])
                        ->chronological()
                        ->jsonPaginate(10);
                },
            ])
            ->findOrFail($id)
        );
    }

}
