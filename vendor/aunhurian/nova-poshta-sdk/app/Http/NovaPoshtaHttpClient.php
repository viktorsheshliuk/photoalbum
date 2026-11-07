<?php

declare(strict_types=1);

namespace AUnhurian\NovaPoshta\SDK\Http;

use AUnhurian\NovaPoshta\SDK\Config\NovaPoshtaConfig;
use AUnhurian\NovaPoshta\SDK\Exceptions\NovaPoshtaApiException;
use AUnhurian\NovaPoshta\SDK\Exceptions\NovaPoshtaHttpException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * HTTP client for Nova Poshta API
 */
class NovaPoshtaHttpClient
{
    /**
     * @var NovaPoshtaConfig
     */
    private NovaPoshtaConfig $config;

    /**
     * @var Client
     */
    private Client $httpClient;

    /**
     * Create a new NovaPoshtaHttpClient instance
     *
     * @param NovaPoshtaConfig $config
     */
    public function __construct(NovaPoshtaConfig $config)
    {
        $this->config = $config;
        $this->httpClient = new Client([
            'base_uri' => $config->getApiUrl(),
            'timeout' => 30,
            'http_errors' => false,
        ]);
    }

    /**
     * Send a request to Nova Poshta API
     *
     * @param string $modelName Model name
     * @param string $calledMethod Method name
     * @param array $methodProperties Method properties
     * @return array Response data
     * @throws NovaPoshtaApiException|NovaPoshtaHttpException
     */
    public function request(string $modelName, string $calledMethod, array $methodProperties = []): array
    {
        $requestData = [
            'apiKey' => $this->config->getApiKey(),
            'modelName' => $modelName,
            'calledMethod' => $calledMethod,
            'methodProperties' => $methodProperties,
        ];

        try {
            $response = $this->httpClient->post('', [
                'json' => $requestData,
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new NovaPoshtaHttpException(
                    'Failed to decode Nova Poshta API response: ' . json_last_error_msg(),
                    $statusCode
                );
            }

            $novaPoshtaResponse = new NovaPoshtaResponse($data, $statusCode);

            return $novaPoshtaResponse->getData();
        } catch (GuzzleException $e) {
            throw new NovaPoshtaHttpException(
                'HTTP request to Nova Poshta API failed: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Send a request to Nova Poshta API and get full response object
     *
     * @param string $modelName Model name
     * @param string $calledMethod Method name
     * @param array $methodProperties Method properties
     * @return NovaPoshtaResponse Response object
     * @throws NovaPoshtaApiException|NovaPoshtaHttpException
     */
    public function requestWithFullResponse(string $modelName, string $calledMethod, array $methodProperties = []): NovaPoshtaResponse
    {
        $requestData = [
            'apiKey' => $this->config->getApiKey(),
            'modelName' => $modelName,
            'calledMethod' => $calledMethod,
            'methodProperties' => $methodProperties,
        ];

        try {
            $response = $this->httpClient->post('', [
                'json' => $requestData,
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
            $data = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new NovaPoshtaHttpException(
                    'Failed to decode Nova Poshta API response: ' . json_last_error_msg(),
                    $statusCode
                );
            }

            return new NovaPoshtaResponse($data, $statusCode);
        } catch (GuzzleException $e) {
            throw new NovaPoshtaHttpException(
                'HTTP request to Nova Poshta API failed: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
