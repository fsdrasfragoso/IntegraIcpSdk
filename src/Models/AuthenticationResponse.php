<?php
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
