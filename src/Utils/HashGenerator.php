<?php
namespace FragosoSoftware\IntegraIcpSdk\Utils;

class HashGenerator
{
    public static function generateSHA256(string $data): string
    {
        return hash('sha256', $data);
    }
}
