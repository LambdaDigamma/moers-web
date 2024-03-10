<?php

namespace Tests\Feature\APIv2;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdvEventAPITest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAdvEvents()
    {
        $response = $this->get('/api/v2/advEvents');

        $response->assertStatus(200);

    }

}
