<?php

namespace App\Http\Controllers;

use Inventas\AppleMaps\Facades\AppleMaps;

class MapAuthController extends Controller
{
    public function token(): string
    {
        return AppleMaps::getToken()->accessToken;
    }
}
