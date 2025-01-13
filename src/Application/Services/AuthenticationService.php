<?php

namespace FragosoSoftware\IntegraIcpSdk\Application\Services;

use FragosoSoftware\IntegraIcpSdk\Application\Interfaces\AuthenticationServiceInterface;
use FragosoSoftware\IntegraIcpSdk\Domain\Entities\AuthenticationResult;
use FragosoSoftware\IntegraIcpSdk\Domain\Exceptions\ApiException;
use FragosoSoftware\IntegraIcpSdk\Infrastructure\Http\HttpClient;

class AuthenticationService implements AuthenticationServiceInterface
{
    private HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function authenticate(string $channelId, string $secretData, string $callbackUri): AuthenticationResult
    {
        $endpoint = "https://services.integraicp.com.br/c/{$channelId}/icp/v3/authentications";
        $query = [
            'secret_data' => $secretData,
            'callback_uri' => $callbackUri,
        ];

        $response = $this->httpClient->get($endpoint, $query);

        if ($response['statusCode'] !== 200) {
            throw new ApiException($response['body']['error']['message'] ?? 'Unknown error', $response['statusCode']);
        }

        return AuthenticationResult::fromArray($response['body']['data']);
    }
}
