<?php

namespace App\Http\Integrations\Moers;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class MoersConnector extends Connector
{
    use AcceptsJson;

    public function resolveBaseUrl(): string
    {
        return 'https://www.moers.de/jsonapi';
    }

    /**
     * @return string[]
     */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * @return string[]
     */
    protected function defaultConfig(): array
    {
        return [];
    }
}
