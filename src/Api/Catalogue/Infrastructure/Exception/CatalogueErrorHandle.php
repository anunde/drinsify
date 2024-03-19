<?php

namespace App\Api\Catalogue\Infrastructure\Exception;

use App\Api\Shared\Infrastructure\Exception\ErrorHandler;
use Symfony\Component\HttpFoundation\JsonResponse;

class CatalogueErrorHandle extends ErrorHandler
{
    public function handle(\Throwable $exception): JsonResponse
    {
        return parent::handle($exception);
    }
}