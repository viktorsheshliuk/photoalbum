<?php

declare(strict_types=1);

namespace AUnhurian\NovaPoshta\SDK\Exceptions;

use Exception;

/**
 * Exception that is thrown when Nova Poshta API returns an error
 */
class NovaPoshtaApiException extends Exception
{
    /**
     * @var array
     */
    private array $errors;

    /**
     * Create a new NovaPoshtaApiException instance
     *
     * @param string $message Error message
     * @param array $errors List of errors from Nova Poshta API
     * @param int $code Error code
     * @param \Throwable|null $previous Previous exception
     */
    public function __construct(string $message = '', array $errors = [], int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * Get the list of errors from Nova Poshta API
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
