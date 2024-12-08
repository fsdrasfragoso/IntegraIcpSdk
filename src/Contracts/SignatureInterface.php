<?php
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

    /**
     * Obtém os detalhes do certificado digital associado à credencial.
     *
     * @param string $credentialId ID da credencial a ser consultada.
     * @param string $secretData Código de segurança utilizado no processo de autenticação.
     * @param string $secretType Tipo de segurança, como 'code_verifier'. (Opcional)
     * @return array Retorna os detalhes da credencial como um array associativo.
     */
    public function getCredentials(string $credentialId, string $secretData, string $secretType = 'code_verifier'): array;
}
