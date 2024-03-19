<?php

namespace App\Api\Profile\Infrastructure\Exception;

use App\Api\Shared\Infrastructure\Exception\ErrorHandler;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProfileErrorHandler extends ErrorHandler
{
    public function handle(\Throwable $exception): JsonResponse
    {
        return parent::handle($exception);
    }
}