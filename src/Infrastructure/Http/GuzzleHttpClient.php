<?php

namespace FragosoSoftware\IntegraIcpSdk\Infrastructure\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GuzzleHttpClient implements HttpClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function get(string $url, array $query = []): array
    {
        try {
            $response = $this->client->request('GET', $url, ['query' => $query]);
            $body = json_decode($response->getBody(), true);
            return [
                'statusCode' => $response->getStatusCode(),
                'body' => $body,
            ];
        } catch (GuzzleException $e) {
            return [
                'statusCode' => $e->getCode(),
                'body' => ['error' => ['message' => $e->getMessage()]],
            ];
        }
    }
}
