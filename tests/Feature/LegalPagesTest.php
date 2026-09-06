<?php

use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;

it('serves a canonical legal page', function (string $path, string $routeName, string $component) {
    expect(route($routeName, absolute: false))->toBe($path);

    get($path)
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page->component($component));
})->with([
    'privacy' => ['/legal/privacy', 'legal.privacy', 'legal/privacy'],
    'terms' => ['/legal/tac', 'legal.tac', 'legal/terms'],
]);

it('redirects the local imprint route to the operator imprint', function () {
    expect(route('legal.imprint', absolute: false))->toBe('/legal/imprint');

    get('/legal/imprint')
        ->assertStatus(301)
        ->assertRedirect('https://inventas.io/impressum');
});
