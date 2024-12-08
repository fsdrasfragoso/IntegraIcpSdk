<?php
namespace FragosoSoftware\IntegraIcpSdk\Services;

use FragosoSoftware\IntegraIcpSdk\Contracts\SignatureInterface;
use FragosoSoftware\IntegraIcpSdk\Contracts\HttpClientInterface;
use FragosoSoftware\IntegraIcpSdk\Models\SignatureResponse;

class SignatureService implements SignatureInterface
{
    private HttpClientInterface $httpClient;
    private string $baseUrl;

    public function __construct(HttpClientInterface $httpClient, string $baseUrl)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = $baseUrl;
    }

    public function sign(array $data): SignatureResponse
    {
        $url = "{$this->baseUrl}/signatures";
        $response = $this->httpClient->post($url, $data);

        return new SignatureResponse($response);
    }
}
