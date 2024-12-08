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
}
