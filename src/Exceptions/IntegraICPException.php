<?php
namespace FragosoSoftware\IntegraIcpSdk\Exceptions;

use Exception;

/**
 * Exceção personalizada para erros relacionados ao SDK IntegraICP.
 */
class IntegraICPException extends Exception
{
    /**
     * Constrói a exceção IntegraICP.
     *
     * @param string $message Mensagem de erro.
     * @param int $code Código de erro (opcional).
     * @param \Throwable|null $previous Exceção anterior (para encadeamento de exceções).
     */
    public function __construct(string $message, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
