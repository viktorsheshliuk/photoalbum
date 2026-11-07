<?php

declare(strict_types=1);

namespace AUnhurian\NovaPoshta\SDK\Http;

use AUnhurian\NovaPoshta\SDK\Exceptions\NovaPoshtaApiException;
use AUnhurian\NovaPoshta\SDK\Exceptions\NovaPoshtaHttpException;

/**
 * Response class for Nova Poshta API
 */
class NovaPoshtaResponse
{
    /**
     * @var array
     */
    private array $responseData;

    /**
     * @var int
     */
    private int $statusCode;

    /**
     * @var bool
     */
    private bool $success;

    /**
     * @var array
     */
    private array $data;

    /**
     * @var array
     */
    private array $errors;

    /**
     * @var array
     */
    private array $warnings;

    /**
     * @var array
     */
    private array $info;

    /**
     * Create a new NovaPoshtaResponse instance
     *
     * @param array $responseData Raw response data
     * @param int $statusCode HTTP status code
     * @throws NovaPoshtaHttpException|NovaPoshtaApiException
     */
    public function __construct(array $responseData, int $statusCode)
    {
        $this->responseData = $responseData;
        $this->statusCode = $statusCode;
        $this->success = $responseData['success'] ?? false;
        $this->data = $responseData['data'] ?? [];
        $this->errors = $responseData['errors'] ?? [];
        $this->warnings = $responseData['warnings'] ?? [];
        $this->info = $responseData['info'] ?? [];

        $this->validate();
    }

    /**
     * Validate the response
     *
     * @throws NovaPoshtaHttpException|NovaPoshtaApiException
     */
    private function validate(): void
    {
        if ($this->statusCode !== 200) {
            throw new NovaPoshtaHttpException(
                "Nova Poshta API returned HTTP error: {$this->statusCode}",
                $this->statusCode
            );
        }

        if (! empty($this->errors)) {
            throw new NovaPoshtaApiException(
                'Nova Poshta API returned errors: ' . implode(', ', $this->errors),
                $this->errors
            );
        }

        if ($this->success === false) {
            $errorMessage = $this->errors ?: ['Unknown API error'];

            throw new NovaPoshtaApiException(
                'Nova Poshta API request failed: ' . implode(', ', $errorMessage),
                $this->errors
            );
        }
    }

    /**
     * Check if the response is successful
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * Get the response data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get the response errors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get the response warnings
     *
     * @return array
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    /**
     * Get the response info
     *
     * @return array
     */
    public function getInfo(): array
    {
        return $this->info;
    }

    /**
     * Get the raw response data
     *
     * @return array
     */
    public function getRawData(): array
    {
        return $this->responseData;
    }

    /**
     * Get the HTTP status code
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
