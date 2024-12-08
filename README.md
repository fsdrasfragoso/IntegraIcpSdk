
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

#### Exemplo de Geração de `secret_data` em Node.js:

```javascript
const crypto = require('crypto');
const base64url = require('base64url');

function generateSecretData() {
  const secret = crypto.randomBytes(32).toString('base64url');
  const challenge = base64url(crypto.createHash('sha256').update(secret).digest());
  return { secret, challenge };
}

const { secret, challenge } = generateSecretData();
console.log('Secret:', secret);
console.log('Challenge:', challenge);
```

#### Exemplo de Geração de `secret_data` em Java:

```java
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.security.SecureRandom;
import java.util.Base64;

public class PKCEGenerator {

    public static String generateCodeVerifier() {
        byte[] bytes = new byte[43];
        SecureRandom secureRandom = new SecureRandom();
        secureRandom.nextBytes(bytes);
        return base64UrlEncode(bytes);
    }

    public static String generateCodeChallenge(String codeVerifier) throws NoSuchAlgorithmException {
        byte[] bytes = codeVerifier.getBytes();
        MessageDigest messageDigest = MessageDigest.getInstance("SHA-256");
        messageDigest.update(bytes);
        byte[] digest = messageDigest.digest();
        return base64UrlEncode(digest);
    }

    private static String base64UrlEncode(byte[] bytes) {
        return Base64.getUrlEncoder().withoutPadding().encodeToString(bytes);
    }

    public static void main(String[] args) {
        try {
            String codeVerifier = generateCodeVerifier();
            System.out.println("Code Verifier: " + codeVerifier);

            String codeChallenge = generateCodeChallenge(codeVerifier);
            System.out.println("Code Challenge: " + codeChallenge);
        } catch (NoSuchAlgorithmException e) {
            e.printStackTrace();
        }
    }
}
```

---

## Suporte

Para dúvidas ou problemas, entre em contato pelo e-mail [produtos.certificadora@valid.com](mailto:produtos.certificadora@valid.com) ou acesse o [Portal Valid](https://valid-sa.atlassian.net/servicedesk/customer/portal/4/group/115/create/51).

---
