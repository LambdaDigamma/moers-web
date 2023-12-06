<?php

use App\Models\RadioBroadcast;

use function Pest\Laravel\expectsJobs;
use function Pest\Laravel\getJson;

test('radio broadcasts can be accessed', function () {

    RadioBroadcast::factory()->count(8)->upcomingStart()->create();
    RadioBroadcast::factory()->count(10)->create([
        'starts_at' => now()->subDays(1)->subHour(),
        'ends_at' => now()->subDays(1),
    ]);

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
    
    expect($response->json('data'))->toHaveCount(8);

});