<?php

declare(strict_types=1);

namespace AUnhurian\NovaPoshta\SDK\Config;

/**
 * Configuration class for Nova Poshta API
 */
class NovaPoshtaConfig
{
    /**
     * API key for Nova Poshta API
     *
     * @var string
     */
    private string $apiKey;

    /**
     * API base URL
     *
     * @var string
     */
    private string $apiUrl = 'https://api.novaposhta.ua/v2.0/json/';

    /**
     * Create a new NovaPoshtaConfig instance
     *
     * @param string $apiKey API key from Nova Poshta
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Get the API key
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Get the API URL
     *
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * Set the API key
     *
     * @param string $apiKey
     * @return self
     */
    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }
}
