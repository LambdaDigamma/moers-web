<?php

namespace Tests\Feature\APIv2;

use AdvEventSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdvEventAPITest extends TestCase
{

    use DatabaseMigrations;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $seeder = new AdvEventSeeder();

        $seeder->run();

    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAdvEvents()
    {
        $response = $this->get('/api/v2/advEvents');

        $response->assertStatus(200)
                 ->assertJsonStructure([[
                    ''
                 ]]);


    }
}
