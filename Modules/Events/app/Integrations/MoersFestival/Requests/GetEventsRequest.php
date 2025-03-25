<?php

namespace Modules\Events\Integrations\MoersFestival\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetEventsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/appdata';
    }
}
