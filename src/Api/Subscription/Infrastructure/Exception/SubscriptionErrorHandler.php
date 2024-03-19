<?php

namespace App\Api\Subscription\Infrastructure\Exception;

use App\Api\Shared\Infrastructure\Exception\ErrorHandler;
use App\Api\Subscription\Domain\Exception\SubscriberAlreadyExistException;
use Symfony\Component\HttpFoundation\JsonResponse;

class SubscriptionErrorHandler extends ErrorHandler
{
    public function handle(\Throwable $exception): JsonResponse
    {
        if ($exception instanceof SubscriberAlreadyExistException) {

            $this->statusCode = 409;
            $this->message = $exception->getMessage();

        }

        return parent::handle($exception);
    }
}