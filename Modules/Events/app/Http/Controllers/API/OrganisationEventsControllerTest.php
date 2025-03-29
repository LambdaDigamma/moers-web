<?php

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Events\Actions\CreateMoersFestivalCollectionEvent;
use Modules\Management\Models\Organisation;
use function Pest\Laravel\getJson;

it('returns organisation events', function () {

    expect(Organisation::query()->where('slug', 'moers-festival')->first())->toBeNull();

    (new CreateMoersFestivalCollectionEvent)->execute(2023);

    $moersFestival = Organisation::query()->where('slug', 'moers-festival')->first();

    expect($moersFestival)->not->toBeNull();

    getJson("/api/v1/organisations/$moersFestival->slug/events")
        ->assertStatus(200)
        ->dump()
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data', 1)
            ->has('links')
            ->has('meta')
        );

});
