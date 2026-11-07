<?php

declare(strict_types=1);

namespace AUnhurian\NovaPoshta\SDK\Exceptions;

use Exception;

/**
 * Exception that is thrown when HTTP request to Nova Poshta API fails
 */
class NovaPoshtaHttpException extends Exception
{
    /**
     * Create a new NovaPoshtaHttpException instance
     *
     * @param string $message Error message
     * @param int $code HTTP status code
     * @param \Throwable|null $previous Previous exception
     */
    public function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
