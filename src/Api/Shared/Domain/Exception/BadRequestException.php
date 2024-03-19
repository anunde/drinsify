<?php

namespace App\Api\Shared\Domain\Exception;

use App\Api\Shared\Infrastructure\Exception\Throwable;

class BadRequestException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}