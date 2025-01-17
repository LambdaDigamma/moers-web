<?php


use Modules\News\Models\Feed;
use function Pest\Laravel\getJson;

test('show feed (/api/v1/feeds/id)', function () {
    $feed1 = Feed::factory()->create();

    getJson("/api/v1/feeds/{$feed1->id}")
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id', 'name', 'extras', 'created_at', 'updated_at', 'deleted_at',
                'posts' => [],
            ],
        ]);
});
