<?php
namespace FragosoSoftware\IntegraIcpSdk\Config;

class Config
{
    private string $channelId;
    private string $baseUrl;

    public function __construct(string $channelId)
    {
        $this->channelId = $channelId;
        $this->baseUrl = getenv('INTEGRAICP_URL') ?: 'https://api.integralcp.com/icp/v3';
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl . "/c/{$this->channelId}";
    }
}
