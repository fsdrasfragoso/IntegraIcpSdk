<?php

namespace FragosoSoftware\IntegraIcpSdk\Infrastructure\Http;

interface HttpClient
{
    public function get(string $url, array $query = []): array;
}
