<?php

namespace Tests\Feature\APIv2;

use App\Models\Entry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function Pest\Faker\fake;

class EntryAPITest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

//        $seeder = new EntrySeeder();
//        $seeder->run();
    }

    public function test_can_get_validated_entries()
    {
        Entry::factory(10)->create();

        $response = $this->get('/api/v2/entries');
        $response->assertStatus(200)
            ->assertJson([[
                'is_validated' => true
            ]]);
    }

    public function test_can_store_entry()
    {
        $data = [
            'name' => fake()->title,
            'tags' => 'Just, Testing',
            'lat' => fake()->latitude,
            'lng' => fake()->longitude,
            'street' => fake()->streetName,
            'house_number' => fake()->buildingNumber,
            'place' => fake()->city,
            'postcode' => '12345',
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
            'name' => fake()->title,
            'tags' => 'Just, Testing',
            'lat' => fake()->latitude,
            'lng' => fake()->longitude,
            'street' => fake()->streetName,
            'house_number' => fake()->buildingNumber,
            'place' => fake()->city,
            'postcode' => '12345',
        ];

        $this->post(route('api.v2.entries.store'), $data)
            ->assertStatus(403);
    }

    public function test_can_update_entry()
    {
        $entry = Entry::factory()->create();
        $updateData = Entry::factory()->make()->toArray();
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
