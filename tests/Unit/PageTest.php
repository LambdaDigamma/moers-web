<?php

namespace Tests\Unit;

use App\Models\Page;
use App\Models\PageBlock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_can_have_page_blocks()
    {
        $pageBlocks = PageBlock::factory()->published()->count(3)->create();
        $page = Page::factory()->published()->create();

        $this->assertCount(0, $page->blocks);
        $page->blocks()->saveMany($pageBlocks);
        $page->load('blocks');
        $this->assertCount(3, $page->blocks);
    }

    public function test_page_to_array()
    {

        $page = Page::factory()->published()->create(['title' => ['en' => 'Test Page']]);
        $page->setTranslation('title', 'de', 'Test Seite');
        $page->setTranslation('title', 'fr', 'Test Page');

        $this->app->setLocale('en');
        $this->assertEquals('Test Page', $page->toArray()['title']);

        $this->app->setLocale('de');
        $this->assertEquals('Test Seite', $page->toArray()['title']);

    }
}
