<?php

namespace App\Api\Checkout\Infrastructure\Exception;

use App\Api\Shared\Infrastructure\Exception\ErrorHandler;
use Symfony\Component\HttpFoundation\JsonResponse;

class CheckoutErrorHandler extends ErrorHandler
{
    public function handle(\Throwable $exception): JsonResponse
    {
        return parent::handle($exception);
    }
}