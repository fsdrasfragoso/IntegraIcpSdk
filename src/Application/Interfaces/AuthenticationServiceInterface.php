<?php

namespace FragosoSoftware\IntegraIcpSdk\Application\Interfaces;

use FragosoSoftware\IntegraIcpSdk\Domain\Entities\AuthenticationResult;

interface AuthenticationServiceInterface
{
    public function authenticate(string $channelId, string $secretData, string $callbackUri): AuthenticationResult;
}
