<?php
namespace FragosoSoftware\IntegraIcpSdk\Services;

use FragosoSoftware\IntegraIcpSdk\Contracts\SignatureInterface;
use FragosoSoftware\IntegraIcpSdk\Contracts\HttpClientInterface;
use FragosoSoftware\IntegraIcpSdk\Models\SignatureResponse;

class SignatureService implements SignatureInterface
{
    private HttpClientInterface $httpClient;
    private string $baseUrl;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = getenv('INTEGRAICP_URL') ?: 'https://api.integralcp.com/icp/v3';
    }

    public function sign(array $data): SignatureResponse
    {
        $url = "{$this->baseUrl}/signatures";
        $response = $this->httpClient->post($url, $data);

        return new SignatureResponse($response);
    }
}
