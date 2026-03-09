<?php

use Modules\Management\Models\Organisation;

use function Pest\Laravel\get;

it('redirects guests away from protected organisation pages', function () {
    $organisation = Organisation::factory()->create([
        'slug' => 'test-organisation',
    ]);

    get(route('organisations.create'))
        ->assertRedirect('/login');

    get(route('organisations.edit', $organisation))
        ->assertRedirect('/login');
});

it('shows public organisation pages without authentication', function () {
    $organisation = Organisation::factory()->create([
        'name' => 'Moers Kultur',
        'slug' => 'moers-kultur',
    ]);

    get(route('organisations.index'))
        ->assertSuccessful();

    get(route('organisations.show', $organisation))
        ->assertSuccessful();
});
