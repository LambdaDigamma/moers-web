<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePage;
use App\Models\Page;
use App\Models\PageBlock;
use Inertia\Inertia;
use Request;
use function foo\func;

class PageController extends Controller
{

    public function __construct()
    {
        $this->middleware('remember')->only('index');
    }

    public function index()
    {
        return Inertia::render('Admin/Pages/Index', [
            'filters' => Request::all('search'),
            'pages' => Page::query()
                ->with('creator')
                ->orderByDesc('created_at')
                ->filter(Request::only('search'))
                ->paginate()
        ]);
    }

    public function edit(Page $page)
    {
        $page->load('blocks');
        return Inertia::render('Admin/Pages/Edit', [
            'page' => $page,
        ]);
    }

    public function preview(Page $page)
    {
        $page->load('blocks');
        return Inertia::render('Admin/Pages/Preview', [
            'page' => $page,
        ]);
    }

    public function update(UpdatePage $request, Page $page)
    {

        $previousBlockIds = $page->blocks->map(function ($block) {
            return $block->id;
        });

        $data = $request->validated();
        $blocks = collect($data['blocks']);
        $newBlockIds = collect([]);

        $blocks->each(function ($blockData) use ($page, $newBlockIds) {

            $blockData = collect($blockData);
            $blockData->put('page_id', $page->id);

            if ($blockData->has('id')) {
                $block = PageBlock::find($blockData->get('id'));
                $block->update($blockData->toArray());
                $newBlockIds->push($block->id);
            } else {
                $block = PageBlock::create($blockData->toArray());
                $newBlockIds->push($block->id);
            }

        });

        $toDelete = $previousBlockIds->diff($newBlockIds);

        $toDelete->each(function ($block_id) {
            PageBlock::find($block_id)->delete();
        });

    }

}
