<?php

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Waste\Models\RubbishStreet;

test('search rubbish street by name', function () {
    RubbishStreet::factory()->create(['name' => 'Musterstraße']);
    RubbishStreet::factory()->create(['name' => 'Baker street']);

    $this->get('/api/v1/rubbish/streets?q=street')
        ->assertStatus(200)
        ->assertJson(
            fn (AssertableJson $json) =>
            $json
                ->has(
                    'data',
                    fn (AssertableJson $json) =>
                    $json->has(1)
                        ->first(
                            fn ($json) =>
                                $json
                                    ->where('name', 'Baker street')
                                    ->etc()
                        )
                )
        );
});
