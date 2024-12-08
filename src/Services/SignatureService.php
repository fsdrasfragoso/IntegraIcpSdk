<?php
namespace FragosoSoftware\IntegraIcpSdk\Services;

use FragosoSoftware\IntegraIcpSdk\Contracts\SignatureInterface;
use FragosoSoftware\IntegraIcpSdk\Contracts\HttpClientInterface;
use FragosoSoftware\IntegraIcpSdk\Models\SignatureResponse;
use InvalidArgumentException;

class SignatureService implements SignatureInterface
{
    private HttpClientInterface $httpClient;
    private string $baseUrl;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;

        // Obter a parte do CHANNEL da variável de ambiente
        $domain = getenv('INTEGRAICP_DOMAIN');
        $channel = getenv('INTEGRAICP_CHANNEL');
        $version = getenv('INTEGRAICP_VERSION') ?: 'v3';

        if (!$this->validateBaseUrl($domain)) {
            throw new InvalidArgumentException('A variável de ambiente INTEGRAICP_DOMAIN deve ser configurada com uma URL válida.');
        }

        if (!$channel) {
            throw new InvalidArgumentException('A variável de ambiente INTEGRAICP_CHANNEL deve ser configurada.');
        }

        // Monta a URL base
        $this->baseUrl = rtrim($domain, '/') . "/c/{$channel}/icp/{$version}";
    }

    public function sign(array $data): SignatureResponse
    {
        $url = "{$this->baseUrl}/signatures";
        $response = $this->httpClient->post($url, $data);

        return new SignatureResponse($response);
    }

    public function getCredentials(string $credentialId, string $secretData, string $secretType = 'code_verifier'): array
    {
        // Monta a URL completa com CREDENTIAL
        $url = "{$this->baseUrl}/credentials/{$credentialId}";

        // Monta a query string
        $queryParams = [
            'secret_data' => $secretData,
            'secret_type' => $secretType,
        ];

        // Faz a requisição HTTP GET
        $response = $this->httpClient->get($url, $queryParams);

        return $response;
    }

    /**
     * Valida se o domínio é uma URL válida.
     *
     * @param string|null $url
     * @return bool
     */
    private function validateBaseUrl(?string $url): bool
    {
        return $url !== null && filter_var($url, FILTER_VALIDATE_URL);
    }
}
