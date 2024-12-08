<?php
namespace FragosoSoftware\IntegraIcpSdk\Models;

class SignatureResponse
{
    private string $signature;

    public function __construct(array $data)
    {
        $this->signature = $data['signature'] ?? '';
    }

    public function getSignature(): string
    {
        return $this->signature;
    }
}
