<?php
namespace FragosoSoftware\IntegraIcpSdk\Services;

use FragosoSoftware\IntegraIcpSdk\Contracts\AuthenticationInterface;
use FragosoSoftware\IntegraIcpSdk\Contracts\HttpClientInterface;
use FragosoSoftware\IntegraIcpSdk\Models\AuthenticationResponse;
use InvalidArgumentException;

class AuthenticationService implements AuthenticationInterface
{
    private HttpClientInterface $httpClient;
    private string $baseUrl;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;

        // Obtém as partes da URL do ambiente
        $domain = getenv('INTEGRAICP_DOMAIN');
        $version = getenv('INTEGRAICP_VERSION') ?: 'v3';
        $channel = getenv('INTEGRAICP_CHANNEL');

        // Valida as partes obrigatórias da URL
        if (!$this->validateBaseUrl($domain)) {
            throw new InvalidArgumentException('A variável de ambiente INTEGRAICP_DOMAIN deve ser configurada com uma URL válida.');
        }

        if (!$channel) {
            throw new InvalidArgumentException('A variável de ambiente INTEGRAICP_CHANNEL deve ser configurada.');
        }

        // Monta a URL base
        $this->baseUrl = rtrim($domain, '/') . "/c/{$channel}/icp/{$version}";
    }

    public function getClearances(array $params): AuthenticationResponse
    {
        $url = "{$this->baseUrl}/authentications";
        $response = $this->httpClient->get($url, $params);

        return new AuthenticationResponse($response);
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
