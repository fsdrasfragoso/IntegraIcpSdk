
# IntegraICP

![IntegraICP Logo](https://developers.integraicp.com.br/images/integraicp-logo.png)

**Revisado em 2024-05-22**

## Sobre a IntegraICP

A **IntegraICP** é uma plataforma que reúne os principais Prestadores de Serviços de Confiança do Brasil, oferecendo **APIs simples** para:

- Criação de Assinaturas Digitais.
- Identificação de Pessoas e Entidades utilizando Certificados Digitais em Nuvem.

Para utilizar os serviços, as aplicações (web ou móveis) precisam de acesso a um **Channel** (equivalente a uma API-Key), que pode ser solicitado por:

- [Portal Valid](https://valid-sa.atlassian.net/servicedesk/customer/portal/4/group/115/create/51)
- E-mail: [produtos.certificadora@valid.com](mailto:produtos.certificadora@valid.com)
## Uso do SDK

A IntegraICP fornece um SDK para facilitar a integração com suas APIs. Veja abaixo como utilizá-lo:

### Contratos

#### `AuthenticationInterface`

```php
namespace FragosoSoftware\IntegraIcpSdk\Contracts;

use FragosoSoftware\IntegraIcpSdk\Models\AuthenticationResponse;

interface AuthenticationInterface
{
    /**
     * Método para obter a lista de Clearances (provedores de autenticação).
     *
     * @param array $params Parâmetros para a requisição (ex.: subject_key, callback_uri).
     * @return AuthenticationResponse Retorna a resposta de autenticação encapsulada em um modelo.
     */
    public function getClearances(array $params): AuthenticationResponse;
}
```

#### `HttpClientInterface`

```php
namespace FragosoSoftware\IntegraIcpSdk\Contracts;

interface HttpClientInterface
{
    public function get(string $url, array $params = []): array;
    public function post(string $url, array $data): array;
}
```

#### `SignatureInterface`

```php
namespace FragosoSoftware\IntegraIcpSdk\Contracts;

use FragosoSoftware\IntegraIcpSdk\Models\SignatureResponse;

interface SignatureInterface
{
    /**
     * Realiza uma assinatura digital usando os dados fornecidos.
     *
     * @param array $data Dados necessários para a assinatura, incluindo `credentialId` e `hashes`.
     * @return SignatureResponse Retorna a resposta da assinatura encapsulada em um modelo.
     */
    public function sign(array $data): SignatureResponse;
}
```

---

### Implementações de Serviços

#### Serviço de Autenticação

```php
namespace FragosoSoftware\IntegraIcpSdk\Services;

use FragosoSoftware\IntegraIcpSdk\Contracts\AuthenticationInterface;
use FragosoSoftware\IntegraIcpSdk\Contracts\HttpClientInterface;
use FragosoSoftware\IntegraIcpSdk\Models\AuthenticationResponse;

class AuthenticationService implements AuthenticationInterface
{
    private HttpClientInterface $httpClient;
    private string $baseUrl;

    public function __construct(HttpClientInterface $httpClient, string $baseUrl)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = $baseUrl;
    }

    public function getClearances(array $params): AuthenticationResponse
    {
        $url = "{$this->baseUrl}/authentications";
        $response = $this->httpClient->get($url, $params);

        return new AuthenticationResponse($response);
    }
}
```

#### Serviço de Assinatura

```php
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
```

---

### Modelos de Resposta

#### `AuthenticationResponse`

```php
namespace FragosoSoftware\IntegraIcpSdk\Models;

class AuthenticationResponse
{
    private array $clearances;

    public function __construct(array $data)
    {
        $this->clearances = $data['clearances'] ?? [];
    }

    public function getClearances(): array
    {
        return $this->clearances;
    }
}
```
---

## Assinatura Eletrônica Qualificada

### Passos para Assinatura Digital:

```text
1. Invocação da API de Autenticação:
   Retorna uma lista de Clearances (provedores).
2. Escolha de Clearance:
   O usuário seleciona o provedor para identificação.
3. Processo de Autenticação:
   A aplicação recebe um CredentialId via callback URI.
4. Preparação da Assinatura Eletrônica:
   Calcula o SHA256 dos conteúdos a serem assinados.
5. Execução do Serviço de Assinatura Eletrônica:
   Realiza a assinatura utilizando o CredentialId e os hashes.
6. Consulta de Credenciais:
   Permite obter detalhes do Certificado Digital usado.
```

---

## Diagrama de Sequência

![Diagrama de Sequência](https://developers.integraicp.com.br/images/sequence-diagram.png)

---

## Referência de APIs

### **Authentications**

**Endpoint:**  
```http
GET /c/{channelId}/icp/v3/authentications
```

**Descrição:**  
Retorna uma lista de Clearances (provedores de confiança) disponíveis para autenticação e assinatura.

#### Parâmetros da Query String

```text
subject_key          Identificação única do proponente (CPF, somente números). (Opcional)
subject_type         Tipo do proponente (ex.: CPF).                           (Opcional)
secret_data          Código de segurança gerado pela aplicação.               (Obrigatório)
secret_type          Tipo de segurança (ex.: code_challenge).                 (Opcional)
callback_uri         URL para resultados da autenticação.                     (Obrigatório)
autostart            Início automático do processo (true/false).              (Opcional)
credential_lifetime  Tempo máximo de uso da credencial (máx.: 168h).          (Opcional)
clearance_lifetime   Tempo máximo de ativação da liberação (máx.: 24h).       (Opcional)
```

---

### **Credentials**

**Endpoint:**  
```http
GET /c/{channelId}/icp/v3/credentials/{credentialId}
```

**Descrição:**  
Obtém detalhes da credencial autenticada, incluindo informações do certificado digital.

---

### **Signatures**

**Endpoint:**  
```http
POST /c/{channelId}/icp/v3/signatures
```

**Descrição:**  
Permite realizar assinaturas eletrônicas em múltiplos conteúdos.

#### Exemplo de Requisição

```json
{
  "credentialId": "01HQNT0RBF8VFPQ6MAVAG1BWPG",
  "secretType": "code_verifier",
  "secretData": "4yrDHoTpVMTvMPemeZlIzfCPMOhd5QXiNxVcmycmWqU",
  "requests": [
    {
      "contentId": "doc_001",
      "contentDigest": "4yrDHoTpVMTvMPemeZlIzfCPMOhd5QXiNxVcmycmWqU=",
      "contentDescription": "Documento de teste",
      "signaturePolicy": "RAW"
    }
  ]
}
```

---

## Implementação da RFC 7636

A **RFC 7636** (Proof Key for Code Exchange by OAuth Public Clients) é usada para mitigar ataques de interceptação de códigos de autorização em comunicações OAuth. Consulte [RFC 7636](https://datatracker.ietf.org/doc/html/rfc7636) para mais detalhes.



---

## Suporte

Para dúvidas ou problemas, entre em contato pelo e-mail [produtos.certificadora@valid.com](mailto:produtos.certificadora@valid.com) ou acesse o [Portal Valid](https://valid-sa.atlassian.net/servicedesk/customer/portal/4/group/115/create/51).

---
