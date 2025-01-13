<?php

namespace FragosoSoftware\IntegraIcpSdk\Domain\Entities;

class AuthenticationResult
{
    public string $requestId;
    public string $channelName;
    public string $channelDescription;
    public string $expireTimestamp;
    public string $currentStatus;

    private function __construct(array $data)
    {
        $this->requestId = $data['requestId'];
        $this->channelName = $data['channelName'];
        $this->channelDescription = $data['channelDescription'];
        $this->expireTimestamp = $data['expireTimestamp'];
        $this->currentStatus = $data['executionStatus']['currentStatus'];
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }
}
