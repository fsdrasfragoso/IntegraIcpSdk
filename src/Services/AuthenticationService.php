<?php
namespace FragosoSoftware\IntegraIcpSdk\Services;

use FragosoSoftware\IntegraIcpSdk\Contracts\AuthenticationInterface;
use FragosoSoftware\IntegraIcpSdk\Contracts\HttpClientInterface;
use FragosoSoftware\IntegraIcpSdk\Models\AuthenticationResponse;

class AuthenticationService implements AuthenticationInterface
{
    private HttpClientInterface $httpClient;
    private string $baseUrl;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = getenv('INTEGRAICP_URL') ?: 'https://api.integralcp.com/icp/v3';
    }

    public function getClearances(array $params): AuthenticationResponse
    {
        $url = "{$this->baseUrl}/authentications";
        $response = $this->httpClient->get($url, $params);

        return new AuthenticationResponse($response);
    }
}
