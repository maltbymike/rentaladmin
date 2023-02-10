<?php

namespace App\Http\Integrations\IRWordpress;

use Saloon\Http\Auth\BasicAuthenticator;
use Saloon\Http\Connector;

class IRWordpressConnector extends Connector
{
    /**
     * The Base URL of the API
     *
     * @return string
     */
    public function resolveBaseUrl(): string
    {
        return 'https://www.ingersollrentall.ca/wp-json/wc/v3';
    }

    /**
     * Default authentication for every request
     * 
     * @return BasicAuthenticator
     */
    protected function defaultAuth(): ?BasicAuthenticator
    {
        return new BasicAuthenticator(env('IRWORDPRESS_CONSUMER_KEY'), env('IRWORDPRESS_CONSUMER_SECRET'));
    }

    /**
     * Default headers for every request
     *
     * @return string[]
     */
    protected function defaultHeaders(): array
    {
        return [];
    }

    /**
     * Default query parameters for every request
     * 
     * @return string[]
     */
    protected function defaultQuery(): array
    {
        return [
            'per_page' => 100,
            'page' => 1,
        ];
    }

    /**
     * Default HTTP client options
     *
     * @return string[]
     */
    protected function defaultConfig(): array
    {
        return [];
    }
}
