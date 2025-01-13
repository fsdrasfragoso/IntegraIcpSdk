<?php

namespace FragosoSoftware\IntegraIcpSdk\Config;

class Config
{
    /**
     * Get the Channel UUID from the .env file.
     */
    public static function getChannelId(): string
    {
        return getenv('CHANNEL_UUID') ?: '063363c6-e614-4b48-b55c-f5a0ed458d88';
    }

    /**
     * Get the Secret Data from the .env file.
     */
    public static function getSecretData(): string
    {
        return getenv('SECRET_DATA') ?: 'E9Melhoa2OwvFrEMTJguCHaoeK1t8URWbuGJSstw-cM';
    }

    /**
     * Get the Channel Name from the .env file.
     */
    public static function getChannelName(): string
    {
        return getenv('CHANNEL_NAME') ?: 'Aplicação de Exemplo';
    }
}
