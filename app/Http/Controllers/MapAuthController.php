<?php


namespace App\Http\Controllers;

use Lcobucci\JWT\Signer\Ecdsa\Sha256;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;

class MapAuthController extends Controller
{
    public function token()
    {
        $url = config('app.url');
        $team = config('services.apple.team');
        $keyID = config('services.apple.maps_key_id');
        $key = config('services.apple.maps_key');

        $time = time();
        $signer = new Sha256();
        $privateKey = new Key($key);

        $token = (new Builder())->issuedBy($team)
                                ->withHeader('kid', $keyID)
                                ->withClaim('origin', $url)
                                ->issuedAt($time)
                                ->expiresAt($time + 3600)
                                ->getToken($signer, $privateKey);

        return $token;
    }
}
