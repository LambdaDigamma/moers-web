<?php

use App\Models\RubbishStreet;

use function Pest\Laravel\get;

it('can be accessed', function () {
    get('/abfallkalender')
        ->assertOk()
        ->assertSee('Suche eine Straße')
        ->assertSee('Abfallkalender');
});

test('detail of street can be accessed', function () {

    $street = RubbishStreet::factory()->create(['name' => 'Ackerweg']);

    get("/abfallkalender/{$street->id}")
        ->assertOk()
        ->assertSeeText('Ackerweg');

});