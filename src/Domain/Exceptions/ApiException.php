<?php

namespace FragosoSoftware\IntegraIcpSdk\Domain\Exceptions;

use Exception;

class ApiException extends Exception
{
    public function __construct(string $message, int $code = 0)
    {
        parent::__construct($message, $code);
    }
}
