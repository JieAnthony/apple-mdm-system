<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Storage;

class DEP
{
    public Client $client;

    public function __construct(string $baseUri, string $username, string $password, public string $depName)
    {
        $this->client = new Client([
            'base_uri' => $baseUri,
            RequestOptions::AUTH => [$username, $password],
            RequestOptions::HEADERS => [
                'User-Agent' => 'nanodep-tools/0',
            ],
        ]);
    }

    public function version()
    {
        return $this->send('GET', '/version');
    }

    public function showDepAssignerProfileUUID()
    {
        return $this->send('GET', \sprintf('/v1/assigner/%s', $this->depName));
    }

    public function putDepAssignerProfileUUID(string $uuid)
    {
        return $this->send('PUT', \sprintf('/v1/assigner/%s', $this->depName), [
            RequestOptions::QUERY => [
                'profile_uuid' => $uuid,
            ],
        ]);
    }

    public function showDepConfig()
    {
        return $this->send('GET', \sprintf('/v1/config/%s', $this->depName));
    }

    public function putDepConfig(array $params)
    {
        return $this->send('PUT', \sprintf('/v1/config/%s', $this->depName), [
            RequestOptions::JSON => $params,
        ]);
    }

    public function showDepTokens()
    {
        return $this->send('GET', \sprintf('/v1/tokens/%s', $this->depName));
    }

    public function putDepTokens(bool $isForce)
    {
        return $this->send('PUT', \sprintf('/v1/tokens/%s', $this->depName), [
            RequestOptions::QUERY => [
                'force' => (int)$isForce,
            ],
        ]);
    }

    public function showDepTokenPki(?string $cn = null, ?int $validityDays = null)
    {
        return $this->send('GET', \sprintf('/v1/tokenpki/%s', $this->depName), [
            RequestOptions::QUERY => [
                'cn' => $cn,
                'validity_days' => $validityDays,
            ],
        ]);
    }

    public function putDepTokenPki(string $body, bool $isForce = false)
    {
        return $this->send('PUT', \sprintf('/v1/tokenpki/%s', $this->depName), [
            RequestOptions::QUERY => [
                'force' => (int)$isForce,
            ],
            RequestOptions::BODY => $body,
        ]);
    }

    public function account()
    {
        return $this->proxy('GET', 'account');
    }

    public function session()
    {
        return $this->proxy('GET', 'session');
    }

    public function defineProfile(array $params)
    {
        return $this->proxy('POST', 'profile', $params);
    }

    public function assignProfile(string $uuid, array $devices)
    {
        return $this->proxy('POST', 'profile/devices', ['devices' => $devices, 'profile_uuid' => $uuid]);
    }

    public function showProfile(string $uuid)
    {
        return $this->proxy('GET', 'profile', query: ['profile_uuid' => $uuid]);
    }

    public function deviceList(array $params = [])
    {
        return $this->proxy('POST', 'server/devices', $params);
    }

    public function deviceDetail(array $devices)
    {
        return $this->proxy('POST', 'devices', \compact('devices'));
    }

    public function deviceActivationLock(string $device, string $escrowKey)
    {
        return $this->proxy('POST', 'device/activationlock', [
            'device' => $device,
            'escrow_key' => $escrowKey,
        ]);
    }

    public function deviceDisown(array $devices)
    {
        return $this->proxy('POST', 'devices/disown', \compact('devices'));
    }

    public function proxy(string $method, string $path, array $params = [], array $query = [])
    {
        $options = [];
        if ($params) {
            $options[RequestOptions::JSON] = $params;
        }
        if ($query) {
            $options[RequestOptions::QUERY] = $query;
        }

        return $this->send($method, \sprintf('/proxy/%s/%s', $this->depName, $path), $options);
    }

    public function send(string $method, string $path, array $options = [])
    {

        $response = $this->client->request($method, $path, $options);

        if (\str_contains($response->getHeaderLine('Content-Type'), 'application/x-pem-file')) {
            $contentDisposition = $response->getHeaderLine('Content-Disposition');
            if (\preg_match('/filename="([^"]+)"/', $contentDisposition, $matches)) {
                $filename = $matches[1];
            } else {
                $filename = \sprintf('%s-%s.pem', \time(), \uniqid());
            }
            Storage::disk('temporary')->put($filename, $response->getBody()->getContents());

            return Storage::disk('temporary')->path($filename);
        }

        return \json_decode($response->getBody()->getContents(), true);
    }
}
