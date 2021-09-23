<?php

use App\Models\RadioBroadcast;

use function Pest\Laravel\getJson;

test('radio broadcasts can be accessed', function () {

    $broadcasts = RadioBroadcast::factory()->count(10)->create();

    $response = getJson('/api/v1/radio-broadcasts')
        ->assertOk()
        ->assertJson([
            'message' => 'Successfully loaded radio broadcasts.',
        ])
        ->assertJsonStructure([
            'message',
            'data' => [
                [
                    'id',
                    'uid',
                    'title',
                    'description',
                    'starts_at',
                    'ends_at',
                    'attach',
                    'url',
                ]
            ]
        ]);
    

});