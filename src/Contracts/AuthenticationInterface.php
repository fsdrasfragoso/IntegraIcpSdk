<?php
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
