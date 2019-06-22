<?php

namespace Tests\Feature\APIv2;

use Tests\TestCase;

class EntryAPITest extends TestCase {

    public function testGetAllEntriesEndpoint()
    {
        $response = $this->get('/api/v2/entries');

        $response->assertStatus(200)
                 ->assertJsonStructure([[
                     'id',
                     'lat',
                     'lng',
                     'name',
                     'tags',
                     'street',
                     'house_number',
                     'postcode',
                     'place',
                     'url',
                     'phone',
                     'monday',
                     'tuesday',
                     'wednesday',
                     'thursday',
                     'friday',
                     'saturday',
                     'sunday',
                     'other',
                     'user_id',
                     'is_validated',
                     'deleted_at',
                     'created_at',
                     'updated_at',
                 ]]);

    }

}
