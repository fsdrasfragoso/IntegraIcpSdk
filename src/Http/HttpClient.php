<?php
namespace FragosoSoftware\IntegraIcpSdk\Http;

use FragosoSoftware\IntegraIcpSdk\Contracts\HttpClientInterface;
use FragosoSoftware\IntegraIcpSdk\Exceptions\IntegraICPException;

class HttpClient implements HttpClientInterface
{
    public function get(string $url, array $params = []): array
    {
        $query = http_build_query($params);
        $fullUrl = $query ? "$url?$query" : $url;

        $response = file_get_contents($fullUrl);

        if ($response === false) {
            throw new IntegraICPException("Failed to perform GET request to $url");
        }

        return json_decode($response, true);
    }

    public function post(string $url, array $data): array
    {
        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            throw new IntegraICPException("Failed to perform POST request to $url");
        }

        return json_decode($response, true);
    }
}
