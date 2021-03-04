<?php


namespace App\Repositories;

use App\Page;
use App\PageBlock;

class PageRepository implements PageRepositoryInterface
{
    public function update($page, array $data, $lang = "de"): Page
    {
        $newBlockIds = collect([]);

        // Retrieve all the IDs of Blocks that already existed.
        $previousBlockIds = $page->blocks->map(function ($block) {
            return $block->id;
        });

        // Iterate over all of the sent blocks.
        $blocks = collect($data['blocks']);
        $blocks->each(function ($blockData) use ($page, $newBlockIds, $lang) {

            // Creating Block Data Collection and Injecting a PageID
            $blockData = collect($blockData);
            $blockData->put('page_id', $page->id);

            // Checking whether that block already existed in
            if ($blockData->has('id')) {
                // Retrieve PageBlock and update it.
                $block = PageBlock::find($blockData->get('id'));

                $block->type = $blockData->get('type');
                $block->order = $blockData->get('order');
                $block->setTranslation('data', $lang, $blockData->get('data'));
                $block->save();

                $newBlockIds->push($block->id);
            } else {
                $block = PageBlock::make();

                $block->type = $blockData->get('type');
                $block->order = $blockData->get('order');
                $block->page_id = $blockData->get('page_id');
                $block->setTranslation('data', $lang, $blockData->get('data'));
                $block->save();

                $newBlockIds->push($block->id);
            }
        });

        // Diffing already existing blocks to the new blocks and deleting those that where deleted.
        $toDelete = $previousBlockIds->toBase()->diff($newBlockIds);
        $toDelete->each(function ($block_id) {
            PageBlock::find($block_id)->delete();
        });

        return Page::find($page->id);
    }
}
