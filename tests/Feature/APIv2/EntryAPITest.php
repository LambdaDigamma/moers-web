<?php

namespace Tests\Feature\APIv2;

use App\Entry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EntryAPITest extends TestCase {

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

//        $seeder = new EntrySeeder();
//        $seeder->run();

    }

    public function test_can_get_validated_entries()
    {

        factory(Entry::class, 10)->create();

        $response = $this->get('/api/v2/entries');
        $response->assertStatus(200)
            ->assertJson([[
                'is_validated' => true
            ]]);

    }

    public function test_can_store_entry()
    {

        $data = [
            'name' => $this->faker->title,
            'tags' => 'Just, Testing',
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
            'street' => $this->faker->streetName,
            'house_number' => $this->faker->buildingNumber,
            'place' => $this->faker->city,
            'postcode' => $this->faker->randomNumber(5),
            'secret' => 'tzVQl34i6SrYSzAGSkBh'
        ];

        $this
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json; charset=utf-8'
            ])
            ->postJson(route('api.v2.entries.store'), $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'id', 'lat', 'lng', 'name', 'tags',
                'street', 'house_number', 'postcode', 'place',
                'created_at', 'updated_at',
            ]);

    }

    public function test_fails_store_entry_no_key()
    {

        $data = [
            'name' => $this->faker->title,
            'tags' => 'Just, Testing',
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
            'street' => $this->faker->streetName,
            'house_number' => $this->faker->buildingNumber,
            'place' => $this->faker->city,
            'postcode' => $this->faker->randomNumber(5),
        ];

        $this->post(route('api.v2.entries.store'), $data)
            ->assertStatus(403);

    }

    public function test_can_update_entry()
    {

        $entry = factory(Entry::class)->create();
        $updateData = factory(Entry::class)->make()->toArray();
        $updateData['secret'] = 'tzVQl34i6SrYSzAGSkBh';

        $this
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json; charset=utf-8'
            ])
            ->putJson(route('api.v2.entries.update', $entry->id), $updateData)
            ->assertJsonStructure([
                'id', 'lat', 'lng', 'name', 'tags',
                'street', 'house_number', 'postcode', 'place',
                'created_at', 'updated_at',
            ]);

    }

}
