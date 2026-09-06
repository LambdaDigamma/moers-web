<?php

use Inventas\AppleMaps\Common\Geocoding\TokenResponse;
use Inventas\AppleMaps\Facades\AppleMaps;

use function Pest\Laravel\get;

it('returns an Apple Maps access token', function () {
    AppleMaps::shouldReceive('getToken')
        ->once()
        ->andReturn(new TokenResponse(
            accessToken: 'apple-maps-access-token',
            expiresInSeconds: 1_800,
        ));

    get('/maps/auth')
        ->assertSuccessful()
        ->assertContent('apple-maps-access-token');
});
