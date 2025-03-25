<?php

namespace Modules\Events\Integrations\MoersFestival;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class MoersFestivalConnector extends Connector
{
    use AcceptsJson;

    public function resolveBaseUrl(): string
    {
        return 'https://www.moers-festival.de/';
    }

    /**
     * @return string[]
     */
    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    protected function defaultConfig(): array
    {
        return [];
    }
}
