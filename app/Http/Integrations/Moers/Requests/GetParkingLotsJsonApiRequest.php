<?php

namespace App\Http\Integrations\Moers\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetParkingLotsJsonApiRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/media/remote_parking_lot';
    }
}

