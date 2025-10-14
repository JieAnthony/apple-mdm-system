<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class MDM
{
    public Client $client;

    public function __construct(string $baseUri, string $username, string $password)
    {
        $this->client = new Client([
            'base_uri' => $baseUri,
            RequestOptions::AUTH => [$username, $password],
            RequestOptions::HEADERS => [
                'User-Agent' => 'nanomdm',
            ],
        ]);
    }

    public function version()
    {
        return $this->send('GET', '/version');
    }

    public function push(array $ids)
    {
        return $this->send('GET', \sprintf('/v1/push/%s', \implode(',', $ids)));
    }

    public function enqueue(array $ids, string $plist, bool $push = true)
    {
        $query = [];

        if (! $push) {
            $query['nopush'] = '1';
        }

        return $this->send('PUT', \sprintf('/v1/enqueue/%s', \implode(',', $ids)), [
            RequestOptions::BODY => $plist,
            RequestOptions::QUERY => $query,
        ]);
    }

    public function send(string $method, string $path, array $options = [])
    {
        $response = $this->client->request($method, $path, $options);

        return \json_decode($response->getBody()->getContents(), true);
    }
}
