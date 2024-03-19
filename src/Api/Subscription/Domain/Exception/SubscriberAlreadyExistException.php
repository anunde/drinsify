<?php

namespace App\Api\Subscription\Domain\Exception;

class SubscriberAlreadyExistException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}